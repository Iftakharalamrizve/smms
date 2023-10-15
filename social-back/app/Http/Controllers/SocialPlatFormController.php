<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SocialMessageService;
use Illuminate\Support\Facades\Redis;
use App\Models\SocialPlatform;
use App\Models\SocialMessage;
use Auth;
use DB;

class SocialPlatFormController extends Controller
{

    private $socialMediaMessageService;

    public function __construct()
    {
        $this->socialMediaMessageService   = new SocialMessageService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentAgentMessageSession()
    {
        $username = Auth::user()->agent_id;
        $pattern = "agent_item_queue:{$username}:*";
        $luaScript = <<<LUA
        local keys = redis.call('keys', ARGV[1])
        local result = {}
        for _, key in ipairs(keys) do
            local items = redis.call('lrange', key, 0, -1)
            for _, item in ipairs(items) do
                table.insert(result, item)
            end
        end
        return result
        LUA;

        $sessionIds = Redis::eval($luaScript, 0, $pattern);
        
        $subquery = SocialMessage::select('session_id', DB::raw('MAX(created_at) AS max_created_at'), DB::raw("SUM(CASE WHEN read_status = 'Un Read' THEN 1 ELSE 0 END) AS un_read_count"))
            ->whereIn('session_id', $sessionIds)
            ->groupBy('session_id');

        $socialMessages = SocialMessage::select('id','message_text','direction','start_time as assign_time','attachments','page_id','customer_id','social_messages.session_id','read_status','subquery.un_read_count')
            ->joinSub($subquery, 'subquery', function ($join) {
                $join->on('social_messages.session_id', '=', 'subquery.session_id')
                    ->whereColumn('social_messages.created_at', '=', 'subquery.max_created_at');
            })
            ->whereIn('social_messages.session_id', $sessionIds) 
            ->get();

        $socialMessageData = $socialMessages->groupBy('page_id')->toArray();
        return $this->respondCreated("Agent Assign Session List", $socialMessageData);
        
    }

    public function agentReplyMessage(Request $request)
    {
        $findLastMessage = (array)DB::table('social_messages as sm')
                                ->select('sm.channel_id', 'sm.page_id', 'sm.customer_id', 'sm.message_id', 'sm.message_text', 'sm.assign_agent', 'sm.direction', 'sm.session_id', 'sm.read_status')
                                ->where(['session_id'=>$request->session_id,'page_id'=>$request->page_id])
                                ->orderBy('created_at','DESC')
                                ->first();
        return $this->socialMediaMessageService->processAndSendReply($findLastMessage,$request); 
    }


    public function getSessionMessage(Request $request)
    {
        $sessionId = $request->input('session_id');
        $pageId = $request->input('page_id');
        $results = DB::table('social_messages as sm')
                        ->select('sm.id', 'sm.channel_id', 'sm.page_id', 'sm.customer_id', 'sm.message_id', 'sm.message_text', 'sm.assign_agent', 'sm.direction', 'sm.attachments', 'sm.session_id', 'sm.read_status', 'sm.start_time', 'sm.created_at', 'sm.updated_at')
                        ->join(DB::raw("(SELECT session_id, MAX(created_at) AS last_message_time FROM `social_messages` WHERE session_id = '$sessionId' AND  page_id = '$pageId') AS sq"), function ($join) {
                            $join->on('sm.session_id', '=', 'sq.session_id')
                                ->whereRaw('sm.created_at >= sq.last_message_time - INTERVAL 30 MINUTE');
                        })
                        ->get();
        
        return $this->respondCreated("Session Message Details", ['session_id'=>$sessionId,'page_id'=>$pageId,'list'=> $results]);
    }
}

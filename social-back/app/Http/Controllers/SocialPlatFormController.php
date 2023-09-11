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
        // $this->SocialPlatformService    = new SocialPlatFormService;
        $this->socialMediaMessageService   = new SocialMessageService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::check()) {

            $data = new \stdClass;
            if(Auth::user()->can('social-platform-list')) {

                $data->headerLink       = 'social-platform.index';
                $data->platform         = config('others.SOCIAL_PLATFORM');
                $data->socialPostData =[];
                $data->socialMessageData =[];
                $pattern = 'agent_item_queue:root:*';
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
                $subquery = SocialMessage::select('session_id', DB::raw('MAX(created_at) AS max_created_at'))
                    ->whereIn('session_id', $sessionIds)
                    ->groupBy('session_id');
                
                $socialMessages = SocialMessage::select('social_messages.*')
                    ->joinSub($subquery, 'subquery', function ($join) {
                        $join->on('social_messages.session_id', '=', 'subquery.session_id')
                            ->whereColumn('social_messages.created_at', '=', 'subquery.max_created_at');
                    })
                    ->whereIn('social_messages.session_id', $sessionIds) 
                    ->get();

                $data->socialMessageData = $socialMessages->groupBy('page_id')->toArray();
                // dd($data);
                // dd($data->socialMessageData);
                return view('social-platform.list')->with(['dataPack'=>$data,'username'=>Auth::user()->username])->withTitle('Social Platform');

            }

            return $this->noPermissionResponse();
        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
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
        $results = DB::table('social_messages as sm')
                        ->select('sm.id', 'sm.channel_id', 'sm.page_id', 'sm.customer_id', 'sm.message_id', 'sm.message_text', 'sm.assign_agent', 'sm.direction', 'sm.attachments', 'sm.session_id', 'sm.read_status', 'sm.start_time', 'sm.created_at', 'sm.updated_at')
                        ->join(DB::raw("(SELECT session_id, MAX(created_at) AS last_message_time FROM `social_messages` WHERE session_id = '$sessionId') AS sq"), function ($join) {
                            $join->on('sm.session_id', '=', 'sq.session_id')
                                ->whereRaw('sm.created_at >= sq.last_message_time - INTERVAL 30 MINUTE');
                        })
                        ->get();
        return response()->json(['status' => true, 'message' => 'Message List Retrive', 'data'=>$results]);            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('social-platform-create')) {

                $data->clientList   = $this->clientService->listItems();
                $data->mediaType    = config('others.SOCIAL_MEDIA');
                $data->routeLink    = 'social-platform.create';
                $data->headerLink   = 'social-platform.index';
                $data->apiToken     = bin2hex(random_bytes(32));

                return view('social-platform.create')->with(['dataPack' => $data])->withTitle('Social Platform');

            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!'); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /* if(Auth::check()) {

            if(Auth::user()->can('social-platform-store')) {

                $result = $this->SocialPlatformService->createItem($request);

                if($result->status == 201){
                    session()->flash('success', 'Record '. $result->messages. ' successfully!');
                }else{
                    session()->flash('error', 'Can not Create !');
                }

                return redirect()->route('social-platform.index');

            }

            return $this->noPermissionResponse();
        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function getPageId($id)
    {

        /* return $this->SocialPlatformService->getPageItem($id); */

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('social-platform-edit')) {

                $result                     = $this->SocialPlatformService->showItem($id);
                $data->SocialPlatformInfo      = $result->data ? $result->data : "";
                $data->clientList           = $this->clientService->listItems();
                $data->mediaType            = config('others.SOCIAL_MEDIA');
                $data->routeLink            = 'social-platform.create';
                $data->headerLink           = 'social-platform.index';
                $data->apiToken             = bin2hex(random_bytes(32));

                return view('social-platform.edit')->with(['dataPack' => $data])->withTitle('Social Platform');

            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!'); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* if(Auth::check()) {

            $data = new \stdClass;

            // dd($request);

            if(Auth::user()->can('social-platform-update')) {

                $result = $this->SocialPlatformService->updateItem($request, $id);

                if($result->status == 208){
                    session()->flash('success', 'Record '. $result->messages. ' successfully!');
                }else{
                    session()->flash('error', 'Can not Update!');
                }

                return redirect()->route('social-platform.index');

            }

            return $this->noPermissionResponse();
        }


        return redirect("login")->withSuccess('Opps! You need to log in first!!'); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        /* if(Auth::check()) {

            if(Auth::user()->can('social-platform-delete') && SocialPlatform::where('id', $id)->first()) {

                $result = $this->SocialPlatformService->deleteItem($id);

                if($result->status == 209){
                    session()->flash('success', 'Record '. $result->messages. ' successfully!');
                }else{
                    session()->flash('error', 'Can not Delete !');
                }

                return redirect()->route('social-platform.index');

            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!'); */

    }
}

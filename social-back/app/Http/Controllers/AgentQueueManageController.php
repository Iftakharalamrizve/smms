<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AgentChatRoomEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Filesystem\Filesystem;
use App\Services\QueueService;
use Illuminate\Support\Facades\Redis;
use DB;

class AgentQueueManageController extends Controller
{

    private $queueService;

    public function __construct(QueueService $queueService)
    {
        $this->queueService    = $queueService;
    }


    public function agentAssignInQueue()
    {
        $agentInitialResponse = $this->queueService->agentInitialOperation();
        return $this->respondCreated($agentInitialResponse['message'],$agentInitialResponse['data']);
    }

    public function getSms()
    {
        return $this->queueService->assigningInfoInAgentItemQueue(json_encode(['name'=>rand(1,10000), 'text' => rand(1,100000)]));
    }

    public function clearMessage($key = 'agent_item_queue:root:4')
    {
        return $this->queueService->releaseAgentFromAgentItemQueue($key);
    }

    

    public function checkStatus()
    {   
        // $this->clearMessage('agent_item_queue:root1:1');
        // $this->clearMessage('agent_item_queue:root1:2');
        // $this->clearMessage('agent_item_queue:root1:3');
        // $this->clearMessage('agent_item_queue:agent2:4');

        // $this->clearMessage('agent_item_queue:root:1');
        // $this->clearMessage('agent_item_queue:root:2');
        // $this->clearMessage('agent_item_queue:root:3');
        // $this->clearMessage('agent_item_queue:root:4');

        // $this->clearMessage('agent_item_queue:agent3:1');
        // $this->clearMessage('agent_item_queue:agent3:2');
        // $this->clearMessage('agent_item_queue:agent3:3');
        // $this->clearMessage('agent_item_queue:agent3:4');
        // $this->clearMessage('agent_item_queue:agent2:1');
        // $this->clearMessage('agent_item_queue:agent2:2');
        // $this->clearMessage('agent_item_queue:agent2:3');
        // $this->clearMessage('agent_item_queue:agent2:4');
        // Redis::lpop('message_queue');
        // foreach(Redis::keys('message_queue') as $key){
        //     Redis::del($key);
        // }
        // foreach(Redis::keys('agent_item_queue:*') as $key){
        //     Redis::del($key);
        // }
        // // Redis::del($key);
        // foreach(Redis::keys('agent_queue') as $key){
        //     Redis::del($key);
        // }
        // Redis::lpop("message_queue");
        // Cache::set('sdata',[]);
        // $listData = Cache::pull('sdata');
        // dd($listData);
        // foreach($listData as $item) {
        //     $pageList[] = ['type'=>$item['type'],'contentDetails'=>json_decode($item['contentDetails'])];
        // }
        // dd(json_encode($pageList));
        // dd(Redis::keys('agent_item_queue:*'));
        // Redis::rpush('agent_queue','1001');
        // Redis::rpush('agent_queue','1016');
        // Redis::rpush('agent_queue','agent5');
        // Redis::rpush('agent_queue','agent4');
        // Redis::rpush('agent_queue','agent3');
        // Redis::rpush('agent_queue','agent1');
        // Redis::rpush('agent_queue','agent2');
        // Redis::lrem('agent_queue', 0, 1016);
        // dd(Redis::lrange('message_queue',0, 0)[0]);
        try {
            $data = [];
            foreach(Redis::keys('agent_item_queue:*') as $key) {
                $info = Redis::lrange($key,0,-1);
                $data[$key] = $info[0];
            }
            
            
            // AgentChatRoomEvent::dispatch('root');
            dd(Redis::lrange('message_queue', 0, -1),Redis::lrange('agent_queue', 0, -1),count($data),$data);
        return response()->json(['message' => 'Shipment status updated']);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

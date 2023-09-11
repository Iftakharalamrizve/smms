<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AgentChatRoomEvent;
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
        return $this->queueService->agentInitialOperation();
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
        // foreach(Redis::keys('agent_item_queue:*') as $key){
        //     Redis::del($key);
        // }
        // Redis::rpush('agent_queue','root');
        // Redis::rpush('agent_queue','agent5');
        // Redis::rpush('agent_queue','agent4');
        // Redis::rpush('agent_queue','agent3');
        // Redis::rpush('agent_queue','agent1');
        // Redis::rpush('agent_queue','agent2');



        try {
            
            $data = [
                Redis::lrange('agent_item_queue:root:1', 0, -1),
                Redis::lrange('agent_item_queue:root:2', 0, -1),
                Redis::lrange('agent_item_queue:root:3', 0, -1),
                Redis::lrange('agent_item_queue:root:4', 0, -1)
            ];
            
            // AgentChatRoomEvent::dispatch('root');
        dd(Redis::lrange('message_queue', 0, -1),$data,Redis::lrange('agent_queue', 0, -1),Redis::keys('agent_item_queue:*'));
        // broadcast(new AgentChatRoomEvent('root'));
        return response()->json(['message' => 'Shipment status updated']);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

<?php

namespace App\Services;

use App\Repositories\QueueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class QueueService
{
    protected $queueServiceRepository;
    protected $messageQueueName = 'message_queue';
    protected $agentQueueName = 'agent_queue';
    protected $agentItemQueueName = 'agent_item_queue';
    protected $isPriority = false;
    protected $priorityAgent;
    protected $totalAgentQuota = 4;

    public function __construct()
    {
        $this->queueServiceRepository = new QueueRepository;
    }

    /**
     * Add data to a specified queue.
     *
     * @param string $queueName The name of the queue.
     * @param mixed $data The data to be added to the queue.
     * 
     */
    public function addDataInQueue($queueName, $data)
    {
        return $this->queueServiceRepository->queueRightPush($queueName, $data);
    }

    /**
     * Get and remove data from a specified queue.
     *
     * @param string $queueName The name of the queue.
     * @return mixed|null The data from the queue, or null if the queue is empty.
     */
    public function getDataInQueue($queueName)
    {
        return $this->queueServiceRepository->queueLeftPop($queueName);
    }


    /**
     * Get retrive all data from a specified queue.
     * Ignore Agent means retrive all agent except specefic agent item 
     * Ignore agent use when Item land in one agent, But agent can not responsed . This business item re assign another agent except curretn agent
     * 
     * @param string $queueName The name of the queue.
     * @param boolean $pattern 
     * @param string $ignoreAgent If have any 
     * @return array|null The data from the queue, or null if the queue is empty.
     */
    public function queueDataRetriveByKey($queueName , $pattern = false, $ignoreAgent=null)
    {
        if($pattern){
            return  $ignoreAgent ? 
            $this->queueServiceRepository->queueRetriveListByKey($queueName,$ignoreAgent)
            :$this->queueServiceRepository->queueRetriveListByKey($queueName);
        }
        return $this->queueServiceRepository->queueItemStatus($queueName);
    }


    /**
    * Get SMS data and assign it to a specific agent or service queue.
    *
    * This method receives SMS data and attempts to assign it to a specific agent based on priority.
    * If no agent is available, the SMS is assigned to a general message queue.
    *
    * @param array $data An array containing minimum information required for queueing.
    * @throws Exception If an error occurs during the assignment process.
    * @return mixed A response indicating the success or failure of the assignment.
    */
    public function assigningInfoInAgentItemQueue(array $data)
    {
        try {
            
            $this->isPriority = $data['priority'];
            $this->priorityAgent = $data['priorityAgent'];
            $freeAgentKey = $this->getFreeAgent();
            if (isset($freeAgentKey)) {
                $status = $this->addDataInQueue($freeAgentKey,$data['session_id']);
                if($status) {
                    return $freeAgentKey;
                }
            }
            // return $this->addDataInQueue($this->messageQueueName, json_encode($data['message_info'])); 
            return null;

        } catch (\Exception $e) {
            // Handle the exception here, if necessary

        }
    }

    /**
    * Get SMS data and assign it sms  queue.
    *
    * This method receives SMS data  assign it sms queue .
    * This message assign in queue for farther process .
    *
    * @param array $data An array containing minimum information required for queueing.
    * @throws Exception If an error occurs during the assignment process.
    */
    public function assigningSMSInSMSQueue(array $data)
    {
        $this->addDataInQueue($this->messageQueueName, json_encode($data));
    }


    /**
     * Releases an agent from the agent item queue.
     *
     * This method removes the specified agent item key from the queue and determines
     * whether the agent should be reassigned or marked as unavailable based on the number
     * of remaining items in the queue.
     *
     * @param string $agentItemKey The key of the agent item to be released.
     * @throws \Exception If an error occurs during the release process.
     * @return mixed A response indicating the success or failure of the release operation.
     */
    public function releaseAgentFromAgentItemQueue(string $agentItemKey)
    {

        try {
            $allKeyExplode = explode(':', $agentItemKey);
            $key = "{$allKeyExplode[0]}:{$allKeyExplode[1]}:*";
            $allItemKey = $this->queueServiceRepository->queueRetriveListByKey($key);
            $totalNumberOfItem = count($allItemKey);

            $this->queueServiceRepository->deleteQueue($agentItemKey);

            if ($totalNumberOfItem == 1) {
                $this->addDataInQueue($this->agentQueueName, $allKeyExplode[1]);
                // return response()->json(['status' => true, 'message' => "Agent is free and reassigned in queue: {$agentItemKey}"]);
            }
            // return response()->json(['status' => true, 'message' => "Agent is not free: {$agentItemKey}"]);
        } catch (\Exception $e) {
            // Handle the exception here, if necessary

        }
    }

    /**
     * Checks if there are any items in the specified queue.
     *
     * This method retrieves information about the items in the queue specified by the given queue name.
     * If there are any items in the queue, it returns true; otherwise, it returns false.
     *
     * @param string $queueName The name of the queue to check.
     * @return bool True if there are items in the queue, false otherwise.
     */
    public function listItemInQueue(string $queueName)
    {
        $itemListInfo = $this->queueDataRetriveByKey($queueName, true);
        return !empty($itemListInfo);
    }

    /**
     * Checks if an item exists in the specified queue.
     *
     * This method checks if there is an item in the queue specified by the given queue name.
     * If an item exists, it returns true; otherwise, it returns false.
     *
     * @param string $queueName The name of the queue to check.
     * @return bool True if an item exists in the queue, false otherwise.
     */
    public function itemInQueue(string $queueName)
    {
        $itemExistInQueue = $this->queueDataRetriveByKey($queueName);
        return $itemExistInQueue;
    }

    /**
     * Checks if the agent item is not present in any queue.
     *
     * This method verifies if the agent item is not present in the agent queue or item queue.
     * If the agent item is not in any queue, it returns true; otherwise, it returns false.
     *
     * @param string $key The key of the agent item to check.
     * @return bool True if the agent item is not in any queue, false otherwise.
     */
    public function agentItemIsNotInQueue(string $key)
    {
        $agentQueueStatus = $this->queueServiceRepository->checkItemExistInQueue($this->agentQueueName, $key);
        $agentItemQueueStatus = $this->queueServiceRepository->queueItemStatus($key);
        return !$agentQueueStatus && !$agentItemQueueStatus;
    }


    /**
     * Check the availability of a free agent in the agent queue and agent service queue.
     * This method checks whether a free agent is available in either the agent queue or agent service queue.
     *
     * First, it checks if the current message or data has any priority. If there is any kind of priority, it attempts to get
     * a Priority Agent from the agent queue or agent service queue.
     * If the Priority Agent is not available in the agent queue or agent service queue, it follows the general rule for agent assignment.
     *
     * General Rule:
     * If a free agent is found in the agent queue, it prepares the agent item key for further processing.
     * If no agent is available in the agent queue, it checks if there is an available agent quota in the agent service queue.
     * If an agent quota is available in the agent service queue, it prepares the agent item key and returns it.
     * If no free agent is found in either queue, it returns null.
     *
     * @return string|null The agent item key if the agent is free, or null if no free agent is available.
     */
    public function getFreeAgent()
    {
        if($this->isPriority){  
            $priorityAgentExistInAgentQueue = $this->queueServiceRepository->queueItemStatus($this->priorityAgent);
            if($priorityAgentExistInAgentQueue){
                return "{$this->agentItemQueueName}:{$this->priorityAgent}:1";
            }else{
                $queueKey = "{$this->agentItemQueueName}:{$this->priorityAgent}";
                $priorityAgentAllItemKey = $this->queueServiceRepository->queueRetriveListByKey("{$queueKey}:*");
                if (count( $priorityAgentAllItemKey) < $this->totalAgentQuota) {
                    $agentBookedSlot = [];
                    foreach($priorityAgentAllItemKey as $item){
                        $keyArrayItem = explode(':', $item);
                        $agentBookedSlot[] = $keyArrayItem[2];
                    }
                    return $this->currentServedAgentKeyGenerate($queueKey, $agentBookedSlot);
                }
            }
        }
        $agent = $this->getDataInQueue($this->agentQueueName);
        if ($agent) {
            return "{$this->agentItemQueueName}:{$agent}:1";
        } else {
            $allItemKey = $this->queueDataRetriveByKey($this->agentItemQueueName.':*',true);
            $groupKey = [];
            $agentBookedSlot = [];
            foreach ($allItemKey as $itemKey) {
                $keyArrayItem = explode(':', $itemKey);
                $key = "$keyArrayItem[0]:$keyArrayItem[1]";
                $agentBookedSlot[$key][] = $keyArrayItem[2];
                $groupKey[$key] = ($groupKey[$key] ?? 0) + 1;
            }

            $minimumServedItemNumber = min($groupKey);
            $bestIdleAgentFromBusyMode = array_search($minimumServedItemNumber, $groupKey);
            if ($groupKey[$bestIdleAgentFromBusyMode] < $this->totalAgentQuota) {
                $speceficAgentBookedSlotList = $agentBookedSlot[$bestIdleAgentFromBusyMode];
                return $this->currentServedAgentKeyGenerate($bestIdleAgentFromBusyMode, $speceficAgentBookedSlotList);
            }
        }
        return null;
    }

    /**
     * Generate the agent item key for the current served agent.
     *
     * This method generates the agent item key for the current served agent based on the assigned agent and booked slot list.
     *
     * @param string $assignAgent The assigned agent.
     * @param array $bookedSlotList The list of booked slots for the assigned agent.
     * @return string The agent item key for the current served agent.
     */
    public function currentServedAgentKeyGenerate($assignAgent, $bookedSlotList)
    {
        
        $currentServedItem = null;
        for ($i = 1; $i <= $this->totalAgentQuota; $i++) {
            if (!in_array($i, $bookedSlotList)) {
                $currentServedItem = $i;
                break;
            }
        }
        return "{$assignAgent}:{$currentServedItem}";
    }



    public function getMessageFromMessageQueue()
    {
        return $this->queueServiceRepository->queueLeftPop($this->messageQueueName);
    }

    public function messageQueueLength()
    {
        return $this->queueServiceRepository->queueLengthNumber($this->messageQueueName);
    }

    public function agentInitialOperation()
    {
        try {
            
            // first check agent is break mode then perform operation
            $userName = Auth::user()->agent_id;
            $agentItemQueueKey = "{$this->agentItemQueueName}:{$userName}:*"; 
            $agentQueueStatus = $this->queueServiceRepository->checkItemExistInQueue($this->agentQueueName,$userName);
            $agentItemQueueStatus = $this->listItemInQueue($agentItemQueueKey);
            if (!$agentItemQueueStatus  && !$agentQueueStatus ) {
                $this->addDataInQueue($this->agentQueueName, $userName);
                return [
                    'message' => 'Agent Assign In Queue', 'data'=>['agentMode'=> 'Ready','name'=>$userName]
                ];
            }else if(!$agentItemQueueStatus  && $agentQueueStatus){
                return [
                    'message' => 'Agent Already In Queue', 'data'=>['agentMode'=> 'Ready','name'=>$userName]
                ];
            }else if(!$agentQueueStatus  && $agentItemQueueStatus){
                return [
                    'message' => 'Agent Is Busy Mode', 'data'=>['agentMode'=> 'Busy','name'=>$userName]
                ];
            }
            
        } catch (\Exception $e) {
            // Handle the exception here, if necessary
        }
        
    }


    public function logAgentSession($key1){
        $data = [];
        $agentQueue = Redis::lrange('agent_queue', 0, -1);
        foreach(Redis::keys('agent_item_queue:*') as $key) {
            $info = Redis::lrange($key,0,-1);
            $data[$key] = $info[0];
        }
        return [count($data),$data,$agentQueue];
    }
    public static function generateApiRequestResponseLog($msg,$data,$data1,$data2,$key=null)
    {
        $path = base_path () . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR ;
        $log = 'User: ' . $_SERVER[ 'REMOTE_ADDR' ] . ' - ' . date ( 'F j, Y, g:i a' ) ."Time". time() . PHP_EOL .
            'Message: ' . (json_encode ($msg)) . PHP_EOL .
            'Data 1: ' . (json_encode ($data)) . PHP_EOL .
            'Data 2: ' . (json_encode ($data1)) . PHP_EOL .
            'Data 3: ' . (json_encode ($data2)) . PHP_EOL .
            'Session Key: ' . $key . PHP_EOL .

            '--------------------------------------------------------------------------------------' . PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents ( $path.'log_' . date ( 'j.n.Y' ) . '.txt' , $log, FILE_APPEND );
    }
}
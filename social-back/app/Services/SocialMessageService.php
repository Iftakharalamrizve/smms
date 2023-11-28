<?php

namespace App\Services;

use App\Repositories\SocialMessageRepository;
use App\Repositories\QueueRepository;
use App\Services\QueueService;
use App\Events\AgentChatRoomEvent;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Auth;

class SocialMessageService
{
    protected $socialMessageRepository, $queueService;
    protected $messageQueueName = 'message_queue';
    protected $agentItemQueueName = 'agent_item_queue';
    protected $socialFormatMessageData = [];
    protected $requestMessageData = [];
    protected $queueServiceRepository;

    public function __construct()
    {
        $this->socialMessageRepository = new SocialMessageRepository();
        $this->queueService = new QueueService();
        $this->queueServiceRepository = new QueueRepository;
    }


    public function processAndSendReply($replyData, $requestData)
    {
        $startTime = date('Y-m-d H:i:s');

        $replyProcessData = [
            'page_id' => $replyData->page_id,
            'customer_id' => $replyData->customer_id,
            'message_id' => $replyData->message_id,
            'assign_agent' => $replyData->assign_agent,
            'channel_id' => $replyData->channel_id,
            'message_text' => $requestData->reply,
            'reply_to' => Auth::user()->agent_id,
            'session_id' => $requestData->session_id,
            'disposition_id' => $requestData->disposition_id ?? NULL,
            'disposition_by' => $requestData->disposition_id ? Auth::user()->agent_id : NULL,
            'direction' => 'OUT',
            'read_status' => 0,
            'sms_state' => 'Delivered',
            'start_time' => $startTime,
            'end_time' => $startTime,
        ];
        return $this->socialMessageRepository->save($replyProcessData);
    }


    public function processNewMessage($messageData, $id)
    {
        $this->requestMessageData = $messageData;
        $messaging = $this->requestMessageData['messaging'][0] ?? [];

        $this->socialFormatMessageData['s_id'] = $id;
        $this->socialFormatMessageData['channel_id'] = 'Facebook';
        $this->socialFormatMessageData['page_id'] = $this->requestMessageData['id'] ?? '';
        $this->socialFormatMessageData['message_id'] = $messaging['message']['mid'] ?? null;
        $this->socialFormatMessageData['message_text'] = $messaging['message']['text'] ?? null;
        $this->socialFormatMessageData['reply_to'] = $messaging['message']['reply_to']['mid'] ?? null;
        $this->socialFormatMessageData['attachments'] = json_encode($messaging['message']['attachments'] ?? '') ?? '';
        $this->socialFormatMessageData['created_time'] = $this->requestMessageData['time'];

        $fromId = $messaging['sender']['id'] ?? '';
        $recipientId = $messaging['recipient']['id'] ?? '';
        $this->socialFormatMessageData['customer_id'] = $this->socialFormatMessageData['page_id'] == $fromId ? $recipientId : $fromId;
        $this->socialFormatMessageData['direction'] = 'IN';

        return $this;
    }

    private function getLastMessageAndPriority($customerId)
    {
        $currentTime = Carbon::now()->subMinutes(30);
        $lastItem = $this->socialMessageRepository->getCustomerLastMessageWithDuration($currentTime, $customerId);
        self::generateApiRequestResponseLog(['Last Item getLastMessageAndPriority'=>$lastItem]);
        $isPriority = $lastItem && $lastItem->sms_state != 'Queue';
        $priorityAgent = $isPriority ? $lastItem->assign_agent : null;
        self::generateApiRequestResponseLog(['Last Item getLastMessageAndPriority'=>$lastItem,'isPriority'=>$isPriority,'$priorityAgent'=>$priorityAgent]);
        return ['lastItem' => $lastItem, 'isPriority' => $isPriority, 'priorityAgent' => $priorityAgent];
    }

    public function saveAndAssignAgent()
    {
        $result = $this->getLastMessageAndPriority($this->socialFormatMessageData['customer_id']);

        $lastItem = $result['lastItem'];
        $isPriority = $result['isPriority'];
        $priorityAgent = $result['priorityAgent'];

        // check latest message existence and disposition
        if ($lastItem && !$lastItem->disposition_id && !$lastItem->disposition_by && $lastItem->sms_state != 'Queue') {
            return $this->handleAssignedMessage($lastItem);
        }

        $saveItem = $this->socialMessageRepository->save($this->socialFormatMessageData);
        if (!$saveItem) {
            return response()->json(['message' => 'Message not inserted in the database']);
        }

        return $this->messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent, $this->socialFormatMessageData['s_id']);
    }

    public function queuMessageOperation()
    {
        $messageData = json_decode($this->queueServiceRepository->queueListRange($this->messageQueueName, 0, 0)[0], true);
        self::generateApiRequestResponseLog(['queuMessageOperation messageData'=>$messageData,'customer_id'=>$messageData['customer_id']]);
        $result = $this->getLastMessageAndPriority($messageData['customer_id']);
        $isPriority = $result['isPriority'];
        $priorityAgent = $result['priorityAgent'];

        $sessionId = $this->generateSessionId();
        $deliveryStatus = false;
        self::generateApiRequestResponseLog(['queuMessageOperation result'=>$result,'sessionId'=>$sessionId]);

        $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
            'session_id' => $sessionId,
            'priority' => $isPriority,
            'priorityAgent' => $priorityAgent,
        ]);
        self::generateApiRequestResponseLog(['agentKey'=>$agentKey,'sessionId'=>$sessionId]);
        if ($agentKey) {
            $this->queueService->getMessageFromMessageQueue();
            $this->handleMessageQueueItem($agentKey, $messageData);
            $deliveryStatus = true;
        }

        return ['status' => $deliveryStatus, 'agent' => $agentKey];
    }

    /**
     * Save the message and assign an agent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function saveAndAssignAgent()
    // {
    //     $currentTime = Carbon::now();
    //     $thirtyMinutesAgo = $currentTime->subMinutes(30); //@TODO

    //     //@TODO Send Last Thirty minutes time for query last 30 minutes latest one message 
    //     $lastItem = $this->socialMessageRepository->getCustomerLastMessageWithDuration($thirtyMinutesAgo, $this->socialFormatMessageData['customer_id']);
    //     $isPriority = false; $priorityAgent = null;
        
    //     //check latest message exist if exist then check have disposition id and by then check last message state in queue if not then decide this message session continute current now 
    //     if ($lastItem && !$lastItem->disposition_id && !$lastItem->disposition_by && $lastItem->sms_state != 'Queue') {
    //         return $this->handleAssignedMessage($lastItem);
    //     }

    //     // We can set this message go to priority if has any message between last 30 minutes and agent alreday give disposition
    //     if ($lastItem && $lastItem->sms_state != 'Queue') {
    //         $isPriority = true;
    //         $priorityAgent = $lastItem->assign_agent;
    //     }

    //     //@TODO need to handle error this section 
    //     $saveItem = $this->socialMessageRepository->save($this->socialFormatMessageData);
    //     if (!$saveItem) {
    //         return response()->json(['message' => 'Message Not insert IN Database']);
    //     }

    //     return $this->messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent, $this->socialFormatMessageData['s_id']);
    // }


    /**
     * Handle already assigned message.
     *
     * @param object $lastItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleMessageQueueItem($agentKey, $messageData)
    {
        try {
            $sessionId = $this->generateSessionId();
            $this->queueService->addDataInQueue($agentKey, $sessionId);
            $currentMessage = $this->socialMessageRepository->getSpecificMessage(['id' => $messageData['id']]);
            $this->handleAssignedSms($currentMessage, $agentKey, $sessionId, $messageData);
        } catch (\Throwable $th) {
        }
    }

    /**
     * Handle already assigned message.
     *
     * @param object $lastItem
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleAssignedMessage($lastItem)
    {
        $this->socialFormatMessageData['session_id'] = $lastItem->session_id;
        $this->socialFormatMessageData['assign_agent'] = $lastItem->assign_agent;
        $this->socialFormatMessageData['sms_state'] = 'Delivered';
        $startTime = date('Y-m-d H:i:s');
        $this->socialFormatMessageData['start_time'] = $startTime;
        $saveItem = $this->socialMessageRepository->save($this->socialFormatMessageData);
        $messageData = [
            'id' => $saveItem['id'],
            'message_text' => $saveItem['message_text'],
            'direction' => $saveItem['direction'],
            'start_time' => $startTime,
            'attachments' => $saveItem['attachments'],
            'page_id' => $saveItem['page_id'],
            'customer_id' => $saveItem['customer_id'],
            'session_id' => $saveItem['session_id'],
            'read_status' => $saveItem['read_status'],
            'un_read_count' => 1
        ];
        // check message state previous broadcast 
        broadcast(new AgentChatRoomEvent($lastItem->assign_agent, $messageData));
        return response()->json(['message' => 'Prev Session Sms Broadcast Successful']);
    }

    /**
     * Assign the message to an agent and store it in the queue.
     *
     * @param array $saveItem
     * @param string $sessionId
     * @param bool $isPriority
     * @param string|null $priorityAgent
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent , $s)
    {
        try {
            $sessionId = $this->generateSessionId();
            $messageData = [
                'id' => $saveItem['id'],
                'message_text' => $saveItem['message_text'],
                'direction' => $saveItem['direction'],
                'start_time' => $saveItem['created_time'],
                'attachments' => $saveItem['attachments'],
                'page_id' => $saveItem['page_id'],
                'customer_id' => $saveItem['customer_id'],
                'read_status' => $saveItem['read_status']
            ];
            

            $messageQueueLength = $this->queueServiceRepository->queueLengthNumber($this->messageQueueName);
            if ($messageQueueLength) {
                $findIndex = $this->findMessageInQueue($messageData);
                if ($findIndex !== null) {
                    $this->queueServiceRepository->setItemSpecificPosition($this->messageQueueName, $findIndex, $messageData);
                    return response()->json(['message' => 'Message Update In Message Queue']);
                }
                $this->queueService->assigningSMSInSMSQueue($messageData);
                return response()->json(['message' => 'Message Insert In Message Queue']);
            }

            $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
                'session_id' => $sessionId,
                'priority' => $isPriority,
                'priorityAgent' => $priorityAgent,
            ]);

            if ($agentKey) {
                $this->handleAssignedSms($saveItem, $agentKey, $sessionId, $messageData);
                return response()->json(['message' => 'Nwe Sms Broadcast Successful'. "Agent Id:".$agentKey. "Session ID: ".$sessionId,"Message Sl". $s]);
            }

            $this->queueService->assigningSMSInSMSQueue($messageData);
            return response()->json(['message' => 'Message Insert In Message Queue']);

        } catch (\Exception $e) {
            $info = $e->getMessage() . " Error Trace ". $e->getTraceAsString(). "Line " .$e->getline();
            return response()->json(['message' => $info]);
        }
        
    }

    /**
     * Find the message in the queue based on customer_id and page_id.
     *
     * @param array $messageData
     * @return int|null
     */
    protected function findMessageInQueue(array $messageData)
    {
        $messageQueueDataList = $this->queueServiceRepository->queueListRange($this->messageQueueName, 0, -1);
        foreach ($messageQueueDataList as $key => $item) {
            $messageItem = json_decode($item, true);
            if (
                $messageData['customer_id'] == $messageItem['customer_id']
                && $messageData['page_id'] == $messageItem['page_id']
            ) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Handle assigned SMS and update social message repository.
     *
     * @param array $saveItem
     * @param string $agentKey
     * @param string $sessionId
     * @param array $messageData
     */
    protected function handleAssignedSms($saveItem, $agentKey, $sessionId, $messageData)
    {
        
        $agentKeyList = explode(':', $agentKey);
        $startTime = date('Y-m-d H:i:s');

        $this->socialMessageRepository->update($saveItem, [
            'assign_agent' => $agentKeyList[1],
            'session_id' => $sessionId,
            'sms_state' => 'Assigned',
            'start_time' => $startTime,
        ]);

        $messageData['session_id'] = $sessionId;
        $messageData['start_time'] = $startTime;
        $messageData['un_read_count'] = 1;
        broadcast(new AgentChatRoomEvent($agentKeyList[1], $messageData));
    }

    /**
     * Generate a new session ID.
     *
     * @return string
     */
    private function generateSessionId()
    {
        $uTime = gettimeofday();
        $refId = $uTime['sec'] . $uTime['usec'];
        $refId = $refId . rand(0, 9999);
        $refId = str_pad($refId, 20, 0, STR_PAD_RIGHT);

        return $refId;
    }

    public function sessionIdleStatusCheckAndReassign()
    {
        $currentAllSessionList = $this->queueServiceRepository->queueRetriveListByKey($this->agentItemQueueName . ':*');
        foreach ($currentAllSessionList as $item) {
            $itemSessionInfoList = $this->queueServiceRepository->queueListRange($item, 0, -1);
            dd($itemSessionInfoList);
            // check session 
        }
    }

    public function freeAgentSession($sessionId)
    {
        $agentId = Auth::user()->agent_id;
        $currentAllSessionList = $this->queueServiceRepository->queueRetriveListByKey($this->agentItemQueueName . ':' . $agentId . ':*');
        foreach ($currentAllSessionList as $item) {
            $itemSessionId = $this->queueServiceRepository->queueListRange($item, 0, -1);
            if ($itemSessionId[0] == $sessionId) {
                $this->queueService->releaseAgentFromAgentItemQueue($item);
                break;
            }
        }
    }

    /**
     * Generate a new session ID.
     *
     * @return array
     */
    // public function queuMessageOperation()
    // {
    //     $currentTime = Carbon::now();
    //     $thirtyMinutesAgo = $currentTime->subMinutes(30);

    //     $messageData = json_decode($this->queueServiceRepository->queueListRange($this->messageQueueName, 0, 0), true);

    //     $lastItem = $this->socialMessageRepository->getCustomerLastMessageWithDuration($thirtyMinutesAgo, $messageData['customer_id']);
        
    //     $isPriority = $lastItem && $lastItem->sms_state != 'Queue';
    //     $priorityAgent = $isPriority ? $lastItem->assign_agent : null;

    //     $sessionId = $this->generateSessionId();
    //     $deliveryStatus = false;

    //     $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
    //         'session_id' => $sessionId,
    //         'priority' => $isPriority,
    //         'priorityAgent' => $priorityAgent,
    //     ]);

    //     if ($agentKey) {
    //         $this->queueService->getMessageFromMessageQueue();
    //         $this->handleMessageQueueItem($agentKey, $messageData);
    //         $deliveryStatus = true;
    //     }

    //     return ['status' => $deliveryStatus, 'agent' => $agentKey];
    // }

    public function logAgentSession($key){
        $data = [];
        foreach(Redis::keys($key) as $key) {
            $info = Redis::lrange($key,0,-1);
            $data[] = $info[0];
        }
        return [count($data),$data];
    }
    public static function generateApiRequestResponseLog($data)
    {
        $path = base_path () . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR ;
        $log = 'User: ' . date ( 'F j, Y, g:i a' ) ."Time". time() . PHP_EOL .
            'Message: ' . (json_encode ($data)) . PHP_EOL .

            '--------------------------------------------------------------------------------------' . PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents ( $path.'log_' . date ( 'j.n.Y' ) . '.txt' , $log, FILE_APPEND );
    }

}

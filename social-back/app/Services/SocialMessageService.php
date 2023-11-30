<?php

namespace App\Services;

use App\Helpers\HelperService;
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
            'sms_state' => $requestData->disposition_id ? 'Complete' :'Delivered',
            'start_time' => $startTime,
            'end_time' => $startTime,
        ];
        return $this->socialMessageRepository->save($replyProcessData);
    }


    /**
     * Process the new message data.
     *
     * @param array $messageData The raw message data.
     * @param string $id The identifier for the message.
     *
     * @return $this
     */
    public function processNewMessage(array $messageData, string $id)
    {
        $this->requestMessageData = $messageData;
        $messaging = $this->requestMessageData['messaging'][0] ?? [];
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

    /**
     * Get the last message, priority status, and priority agent for a customer.
     *
     * This method queries the database for the customer's last message that is not in the queue.
     * If a last message is found, it sets priority to true and retrieves the priority agent.
     *
     * @param int $customerId The ID of the customer for whom to fetch the last message.
     * @param int $pageId The ID of the page for whom to fetch the last message.
     *
     * @return array An associative array containing:
     *               - 'lastItem': The last message item for the customer.
     *               - 'isPriority': A boolean indicating whether the last message is a priority.
     *               - 'priorityAgent': The agent assigned to the priority message, or null if not a priority.
     */
    private function getLastMessageAndPriority($customerId, $pageId)
    {
        // Get the current time configuration for message duration.
        $currentTime = HelperService::getMessageDurationTime();

        // Query the database for the customer's last message not in the queue.
        $lastItem = $this->socialMessageRepository->getCustomerLastMessageWithDuration($currentTime, $customerId, $pageId);

        // Check if a last message is found and it is not in the queue.
        $isPriority = $lastItem && $lastItem->sms_state != 'Queue';

        // Retrieve the priority agent if the last message is a priority, otherwise set to null.
        $priorityAgent = $isPriority ? $lastItem->assign_agent : null;

        // Return the result as an associative array.
        return ['lastItem' => $lastItem, 'isPriority' => $isPriority, 'priorityAgent' => $priorityAgent];
    }


    /**
     * Save the message and assign an agent based on priority.
     *
     * This method first retrieves information about the last message and its priority status.
     * If the last message is incomplete, it assigns the message to an agent.
     * If the last message is complete or does not exist, a new message is created, assigned to an agent,
     * and a new session is created.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function saveAndAssignAgent()
    {
        // Get information about the last message and its priority status.
        $result = $this->getLastMessageAndPriority($this->socialFormatMessageData['customer_id'], $this->socialFormatMessageData['page_id']);

        // Assign result data to individual variables.
        $lastItem = $result['lastItem'];
        $isPriority = $result['isPriority'];
        $priorityAgent = $result['priorityAgent'];

        // Check if the last message is not complete continue previous session.
        if ($lastItem && $lastItem->sms_state != 'Complete') {
            return $this->handleAssignedMessage($lastItem);
        }

        // If the last message is complete or does not exist, create a new message.
        $saveItem = $this->socialMessageRepository->save($this->socialFormatMessageData);

        // Check if the new message was successfully inserted into the database.
        if (!$saveItem) {
            return response()->json(['message' => 'Message not inserted in the database']);
        }

        // Assign the new message to an agent and store it in the queue.
        return $this->messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent);
    }

    /**
     * Process the message queue operation.
     *
     * This method retrieves the message data from the message queue,
     * gets the last message and priority information from the database,
     * generates a session ID, and attempts to assign the message to an available agent.
     * If an agent is found, the message is removed from the message queue and processed.
     *
     * @return array An associative array containing:
     *               - 'status': A boolean indicating the success of the delivery.
     *               - 'agent': The key of the assigned agent, or null if not assigned.
     */
    public function queuMessageOperation()
    {
        // Retrieve and decode message queue data.
        $messageData = json_decode($this->queueServiceRepository->queueListRange($this->messageQueueName, 0, 0)[0], true);

        // Get the last message and priority information from the database.
        $result = $this->getLastMessageAndPriority($messageData['customer_id'], $messageData['page_id']);

        // Assign result data to individual variables.
        $isPriority = $result['isPriority'];
        $priorityAgent = $result['priorityAgent'];

        // Generate a session ID.
        $sessionId = HelperService::generateSessionId();
        $deliveryStatus = false;

        // Get the current available agent key, or null if not found.
        $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
            'session_id' => $sessionId,
            'priority' => $isPriority,
            'priorityAgent' => $priorityAgent,
        ]);

        // If an agent key is found, remove the message from the message queue and handle the message queue item.
        if ($agentKey) {
            $this->queueService->getMessageFromMessageQueue();
            $this->handleMessageQueueItem($agentKey, $sessionId, $messageData);
            $deliveryStatus = true;
        }

        // Return the result as an associative array.
        return ['status' => $deliveryStatus, 'agent' => $agentKey];
    }


    /**
     * Handle already assigned message.
     *
     * @param object $lastItem
     * @return void
     */
    public function handleMessageQueueItem($agentKey, $sessionId, $messageData)
    {
        try {
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
    public function messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent)
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
                $findInformation = $this->findMessageInQueue($messageData);
                if ($findInformation['status'] == true) {
                    $messageData['queue_session_id'] = $findInformation['item']['queue_session_id'];
                    $this->handleQueueSms($saveItem,$messageData['queue_session_id']);
                    $this->queueServiceRepository->setItemSpecificPosition($this->messageQueueName, $findInformation['key'], $messageData);
                    return response()->json(['message' => 'Message Update In Message Queue']);
                }
                $this->handleQueueSms($saveItem,$sessionId);
                $this->queueService->assigningSMSInSMSQueue($messageData, $sessionId);
                return response()->json(['message' => 'Message Insert In Message Queue']);
            }

            $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
                'session_id' => $sessionId,
                'priority' => $isPriority,
                'priorityAgent' => $priorityAgent,
            ]);

            if ($agentKey) {
                $this->handleAssignedSms($saveItem, $agentKey, $sessionId, $messageData);
                return response()->json(['message' => 'Nwe Sms Broadcast Successful'. "Agent Id:".$agentKey. "Session ID: ".$sessionId]);
            }
            $this->handleQueueSms($saveItem,$sessionId);
            $this->queueService->assigningSMSInSMSQueue($messageData,$sessionId);
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
     * @return array
     */
    protected function findMessageInQueue(array $messageData)
    {
        $messageQueueDataList = $this->queueServiceRepository->queueListRange($this->messageQueueName, 0, -1);
        $status = false;
        $key = null;
        $messageItem = null;
        foreach ($messageQueueDataList as $k => $item) {
            $messageItem = json_decode($item, true);
            if (
                $messageData['customer_id'] == $messageItem['customer_id']
                && $messageData['page_id'] == $messageItem['page_id']
            ) {
               $status = true;
               $key = $k;
            }
        }
        return ['status'=>$status, 'key'=>$key , 'item'=> $messageItem];
    }


    /**
     * Handle assigned SMS and update social message repository.
     *
     * @param array $saveItem
     * @param string $agentKey
     * @param string $sessionId
     * @param array $messageData
     */
    protected function handleQueueSms($saveItem, $queueSessionId)
    {
        try {
            self::generateApiRequestResponseLog(['Queue Session Id item id'=> $saveItem['id'],'queue_session_id'=>$queueSessionId]);
            $this->socialMessageRepository->update($saveItem, [
                'queue_session_id'=> $queueSessionId
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            self::generateApiRequestResponseLog(['Error'=> $saveItem['id'],'queue_session_id'=>$queueSessionId]);
        }
        
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

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
    protected $messageRRQueueName = 'message_rr_queue';
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
    public function processFacebookNewMessage(array $messageData)
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

        // Check if the last message is not complete continue previous session that called Continues Dialogue.
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

    public function queuRRMessageOperation()
    {
        // Retrieve and decode message queue data.
        $messageData = json_decode($this->queueServiceRepository->queueListRange($this->messageRRQueueName, 0, 0)[0], true);

        // Generate a session ID.
        $sessionId = HelperService::generateSessionId();
        $deliveryStatus = false;
        // Get the current available agent key, or null if not found.
        $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
            'session_id' => $sessionId,
            'priority' => false,
            'priorityAgent' => null,
            'ignoreAgent' => $messageData['ignoreAgent']
        ]);

        // If an agent key is found, remove the message from the message queue and handle the message queue item.
        if ($agentKey) {
            $this->queueService->getMessageFromRRMessageQueue();
            $this->handleMessageQueueItem($agentKey, $sessionId, $messageData);
            $deliveryStatus = true;
        }

        // Return the result as an associative array.
        return ['status' => $deliveryStatus, 'agent' => $agentKey];

    }


    /**
     * Handle a queued message item.
     *
     * This method updates the information for a queued message that has already been assigned to an agent.
     * It retrieves the current message information from the database using the provided message ID,
     * then calls another method to update the database and broadcast the changes.
     *
     * @param string $agentKey The key of the assigned agent.
     * @param string $sessionId The session ID associated with the message.
     * @param array $messageData The information of the queued message.
     *                           Should include at least 'id' to identify the message.
     *
     * @return void
     */
    public function handleMessageQueueItem($agentKey, $sessionId, $messageData)
    {
        try {
            // Retrieve the current message information from the database.
            $currentMessage = $this->socialMessageRepository->getSpecificMessage(['id' => $messageData['id']]);

            // Handle the assigned SMS by updating the database and broadcasting changes.
            $this->handleAssignedSms($currentMessage, $agentKey, $sessionId, $messageData);
        } catch (\Throwable $th) {
            // Handle any exceptions that might occur during the process.
            // Consider logging or reporting the exception details.
        }
    }

    /**
     * Handle the current message with previous information.
     *
     * This method works to handle a continued message session. 
     * When a new message arrives, it checks if the message has any session. 
     * This method retrieves the last item of the current message session from the database 
     * and binds its information with the current message. It then saves the current message in the database.
     * After saving, it processes the data for agent broadcast.
     *
     * @param object $lastItem The last item of the current message session.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleAssignedMessage($lastItem)
    {
        // Set properties based on the last item's information.
        $this->socialFormatMessageData['session_id'] = $lastItem->session_id;
        $this->socialFormatMessageData['assign_agent'] = $lastItem->assign_agent;
        $this->socialFormatMessageData['sms_state'] = 'Delivered';
        
        // Set start time and save the current message in the database.
        $startTime = date('Y-m-d H:i:s');
        $this->socialFormatMessageData['start_time'] = $startTime;
        $saveItem = $this->socialMessageRepository->save($this->socialFormatMessageData);
        
        // Prepare data for broadcast.
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

        // before broadcast need to check this session in re route process
        
        
        // Check the message state and broadcast the previous state.
        broadcast(new AgentChatRoomEvent($lastItem->assign_agent, $messageData));
        
        return response()->json(['message' => 'Previous Session SMS Broadcast Successful']);
    }

    /**
     * Assigns and stores a message on the queue.
     *
     * This method handles the process of assigning and storing a message in the message queue.
     * It generates a session ID, formats the message data, checks the message queue's length,
     * and either updates the existing message in the queue or assigns a new session ID for the message.
     * It also handles the case where an agent is available and assigns the message to the agent,
     * or adds the message to the message queue if no agent is available.
     *
     * @param array $saveItem The data of the message to be assigned and stored.
     * @param bool $isPriority Indicates whether the message has priority.
     * @param string|null $priorityAgent The agent with priority if $isPriority is true.
     * @param bool $isIgnoreAgent Indicates whether the message has any ignore agent by default false.
     * @param string|null $ignoreAgent The agent with priority if $isIgnoreAgent is true $ignoreAgent has data.
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent , $isIgnoreAgent = false , $ignoreAgent = null)
    {
        try {
            $sessionId = HelperService::generateSessionId();
            $messageData = [
                'id' => $saveItem['id'],
                'message_text' => $saveItem['message_text'],
                'direction' => $saveItem['direction'],
                'start_time' => $saveItem['start_time'],
                'attachments' => $saveItem['attachments'],
                'page_id' => $saveItem['page_id'],
                'customer_id' => $saveItem['customer_id'],
                'read_status' => $saveItem['read_status']
            ];

            // Get the current message queue length.
            $messageQueueLength = $this->queueServiceRepository->queueLengthNumber($this->messageQueueName);

            // Check if the message queue has messages.
            if ($messageQueueLength) {
                
                // Check the message queue
                $findInformation = $this->findMessageInQueue($messageData, $this->messageQueueName);
                if ($findInformation['status'] == true) {
                    return $this->updateMessageInQueue($saveItem, $messageData, $this->messageQueueName, 'Message Updated In Message Queue');
                }

                // Check the re route  queue
                $findInformation = $this->findMessageInQueue($messageData, $this->messageRRQueueName);
                if ($findInformation['status'] == true) {
                    return $this->updateMessageInQueue($saveItem, $messageData, $this->messageQueueName, 'Message Re Route Updated In Message Queue');
                }

                // If the current message is not in the message queue, update the database with a new queue session ID.
                $this->handleQueueSms($saveItem, $sessionId);
                // Assign the message to the message queue with the session ID.
                $this->queueService->assigningSMSInSMSQueue($messageData, $sessionId, $isIgnoreAgent, $ignoreAgent);
                return response()->json(['message' => 'Message Inserted In Message Queue']);
            }

            // If the message queue has no messages, try to get an agent key.
            $agentKey = $this->queueService->assigningInfoInAgentItemQueue([
                'session_id' => $sessionId,
                'priority' => $isPriority,
                'priorityAgent' => $priorityAgent,
                'ignoreAgent' => $isIgnoreAgent ? $ignoreAgent : null
            ]);

            // If an agent key is available, handle the assigned SMS.
            if ($agentKey) {
                $this->handleAssignedSms($saveItem, $agentKey, $sessionId, $messageData);
                HelperService::generateApiRequestResponseLog(['generated Session id when assign agent----------------'=>[$agentKey, $sessionId]]);
                return response()->json(['message' => 'New SMS Broadcast Successful' . "Agent Id:" . $agentKey . "Session ID: " . $sessionId]);
            }

            // If the agent key is null, add the message to the message queue and update the current message session ID and agent key.
            $this->handleQueueSms($saveItem, $sessionId);
            // Assign the message to the message queue.
            $this->queueService->assigningSMSInSMSQueue($messageData, $sessionId, $isIgnoreAgent, $ignoreAgent);
            return response()->json(['message' => 'Message Inserted In Message Queue']);

        } catch (\Exception $e) {
            // Handle exceptions and return an informative response.
            $info = $e->getMessage() . " Error Trace " . $e->getTraceAsString() . "Line " . $e->getLine();
            return response()->json(['message' => $info]);
        }
    }


    // Function to update the message in the message queue
    private function updateMessageInQueue($saveItem, $messageData, $queueName, $responseMessage)
    {
        $findInformation = $this->findMessageInQueue($messageData, $queueName);

        if ($findInformation['status'] == true) {
            // Update the database with the message session.
            $this->handleQueueSms($saveItem, $findInformation['item']['queue_session_id']);
            // Update the current message in the message queue with necessary information.
            $messageData['queue_session_id'] = $findInformation['item']['queue_session_id'];
            $this->queueServiceRepository->setItemSpecificPosition($this->messageQueueName, $findInformation['key'], $messageData);
            return response()->json(['message' => $responseMessage]);
        }

        return null;
    }

    /**
     * Find the message in the queue based on customer_id and page_id.
     *
     * @param array $messageData
     * @return array
     */
    protected function findMessageInQueue(array $messageData , $queueName)
    {
        $messageQueueDataList = $this->queueServiceRepository->queueListRange($queueName, 0, -1);
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
            $this->socialMessageRepository->update($saveItem, [
                'queue_session_id'=> $queueSessionId
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            HelperService::generateApiRequestResponseLog(['Error'=> $saveItem['id'],'queue_session_id'=>$queueSessionId]);
        }
        
    }



    /**
     * Handles the assignment of an SMS to an agent.
     *
     * This method updates the database with the assigned agent, session ID, and start time.
     * It also broadcasts the assigned SMS to the agent's chat room.
     *
     * @param array $saveItem The data of the message to be assigned.
     * @param string $agentKey The key representing the agent and session information.
     * @param string $sessionId The session ID associated with the assigned message.
     * @param array $messageData The information of the assigned message.
     *
     * @return void
     */
    protected function handleAssignedSms($saveItem, $agentKey, $sessionId, $messageData)
    {
        // Extract agent key information.
        $agentKeyList = explode(':', $agentKey);

        // Get the current date and time.
        $startTime = date('Y-m-d H:i:s');

        // Update the database with the assigned agent, session ID, and start time.
        $this->socialMessageRepository->update($saveItem, [
            'assign_agent' => $agentKeyList[1],
            'session_id' => $sessionId,
            'sms_state' => 'Assigned',
            'start_time' => $startTime,
        ]);

        // Prepare data for broadcast.
        $messageData['session_id'] = $sessionId;
        $messageData['start_time'] = $startTime;
        $messageData['un_read_count'] = 1;

        // Broadcast the assigned SMS to the agent's chat room.
        broadcast(new AgentChatRoomEvent($agentKeyList[1], $messageData));
    }
    public function sessionIdleStatusCheckAndReassign()
    {
        $currentAllSessionList = $this->queueServiceRepository->queueRetriveListByKey($this->agentItemQueueName . ':*');

        $reRouteSessionList = [];
        foreach ($currentAllSessionList as $item) {
            $assignedAgentKeyArray = explode(':', $item);
            HelperService::generateApiRequestResponseLog(["Every Single Item"=>$assignedAgentKeyArray,__LINE__,__FILE__]);
            $itemSessionInfoList = $this->queueServiceRepository->queueListRange($item, 0, -1);
            HelperService::generateApiRequestResponseLog(["itemSessionInfoList"=>$itemSessionInfoList,__LINE__,__FILE__]);
            $currentSessionId = count($itemSessionInfoList) > 0 ? $itemSessionInfoList[0] : null;
            HelperService::generateApiRequestResponseLog(["$currentSessionId"=>$currentSessionId,__LINE__,__FILE__]);
            if ($currentSessionId) {
                $autoReRouteStatus = HelperService::currentSessionReRouteStatus($assignedAgentKeyArray[1], $currentSessionId);

                if ($autoReRouteStatus) {

                    $reRouteSessionList[$assignedAgentKeyArray[1]][] = $currentSessionId;
                }
            }
        }

        HelperService::generateApiRequestResponseLog([$reRouteSessionList]);
        foreach ($reRouteSessionList as $key => $sessionList) {
            HelperService::generateApiRequestResponseLog(['BroadCast Item' => [$key,$sessionList],__LINE__,__FILE__]);
            broadcast(new AgentChatRoomEvent($key,$sessionList,'agent_re_route_event'));  // free or remove item from frontend
            foreach($sessionList as $listItem){
                HelperService::generateApiRequestResponseLog(["Before Free Session List" => Redis::keys($this->agentItemQueueName . ':*'),'Before Re Route Session Id'=>$listItem,__LINE__,__FILE__]);
                $this->freeAgentSession($listItem, $key);
                HelperService::generateApiRequestResponseLog(["After Free Session List" => Redis::keys($this->agentItemQueueName . ':*'),'After Free Session List Session Id'=>$listItem,__LINE__,__FILE__]);
                $reRouteItem = $this->socialMessageRepository->getSpecificMessage(['session_id'=>$listItem]);
                $this->messageAssignAndStoreOnQueue($reRouteItem,false, null, true, $key); 
                HelperService::generateApiRequestResponseLog(["After Re Route Assign Session List" => Redis::keys($this->agentItemQueueName . ':*'),__LINE__,__FILE__]);

            }
        }
    }

    public function freeAgentSession( $sessionId, $agentId = null)
    {
        $queueKeyPrefix = $this->agentItemQueueName . ':' . $agentId . ':*';

        $currentAllSessionList = $this->queueServiceRepository->queueRetriveListByKey($queueKeyPrefix);

        foreach ($currentAllSessionList as $item) {
            $itemSessionId = $this->queueServiceRepository->queueListRange($item, 0, -1);

            if ($itemSessionId[0] == $sessionId) {
                HelperService::unlockSessionForAgent($agentId,$sessionId);
                $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

            if (isset($trace[1]['function'])) {
                $callingMethod = $trace[1]['function'];
                HelperService::generateApiRequestResponseLog( "This function is called by: $callingMethod\n");
            } else {
                HelperService::generateApiRequestResponseLog("Unable to determine calling method ");
            }
                $this->queueService->releaseAgentFromAgentItemQueue($item);
                return;
            }
        }
    }

}

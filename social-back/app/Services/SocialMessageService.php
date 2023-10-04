<?php

namespace App\Services;

use App\Repositories\SocialMessageRepository;
use App\Repositories\QueueRepository;
use App\Services\QueueService;
use App\Events\AgentChatRoomEvent;
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
        $replyData['message_text'] = $requestData->reply;
        $replyData['reply_to'] = Auth::user()->username;
        $replyData['direction'] = 'OUT';
        $replyData['session_id'] = $requestData->session_id;
        $replyData['read_status'] = 'Read';
        $replyData['sms_state'] = 'Delivered';
        // $replyData['disposition_id'] = $requestData->disposition_id??null;
        // $replyData['disposition_by'] = $requestData->disposition_id?Auth::user()->username:null;
        $saveItem = $this->socialMessageRepository->save( $replyData);
        if($saveItem){
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function saveAgentReply($replyProcessData)
    {
        
    }

    public function processNewMessage($messageData)
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
     * Save the message and assign an agent.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAndAssignAgent()
    {
        $currentTime = Carbon::now();
        $thirtyMinutesAgo = $currentTime->subMinutes(30);
        $lastItem = $this->socialMessageRepository->getCustomerLastMessageWithDuration($thirtyMinutesAgo, $this->socialFormatMessageData['customer_id']);
        $isPriority = false;
        $priorityAgent = null;

        if ($lastItem && !$lastItem->disposition_id && !$lastItem->disposition_by && $lastItem->sms_state != 'Queue') {
            return $this->handleAssignedMessage($lastItem);
        }

        if ($lastItem && $lastItem->sms_state != 'Queue') {
            $isPriority = true;
            $priorityAgent = $lastItem->assign_agent;
        }

        $saveItem = $this->socialMessageRepository->save($this->socialFormatMessageData);
        if (!$saveItem) {
            return response()->json(['message' => 'Message Not insert IN Database']);
        }

        return $this->messageAssignAndStoreOnQueue($saveItem, $isPriority, $priorityAgent);
    }


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
            $this->queueService->addDataInQueue($agentKey,$sessionId);
            $currentMessage = $this->socialMessageRepository->getSpecificMessage(['id'=> $messageData['id']]);
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
            'assign_time' => $startTime,
            'attachments' => $saveItem['attachments'],
            'page_id' => $saveItem['page_id'],
            'customer_id' => $saveItem['customer_id'],
            'session_id' => $saveItem['session_id'],
        ];
        broadcast(new AgentChatRoomEvent($lastItem->assign_agent, $messageData));
        return response()->json(['message' => 'Sms Broadcast Successful']);
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
        $sessionId = $this->generateSessionId();
        $messageData = [
            'id' => $saveItem['id'],
            'message_text' => $saveItem['message_text'],
            'direction' => $saveItem['direction'],
            'assign_time' => $saveItem['created_time'],
            'attachments' => $saveItem['attachments'],
            'page_id' => $saveItem['page_id'],
            'customer_id' => $saveItem['customer_id'],
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
            return response()->json(['message' => 'Sms Broadcast Successful']);
        }

        $this->queueService->assigningSMSInSMSQueue($messageData);
        return response()->json(['message' => 'Message Insert In Message Queue']);
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
        $messageData['assign_time'] = $startTime;
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
        $refId = $uTime['sec'].$uTime['usec'];
        $refId = $refId.rand(0,9999);        
        $refId = str_pad($refId, 20, 0, STR_PAD_RIGHT);

        return $refId;
    }

    public function sessionIdleStatusCheckAndReassign()
    {
        $currentAllSessionList = $this->queueServiceRepository->queueRetriveListByKey($this->agentItemQueueName.':*');
        foreach($currentAllSessionList as $item){
            $itemSessionInfoList = $this->queueServiceRepository->queueListRange($item,0,-1);
            dd($itemSessionInfoList);
        }

    }
}
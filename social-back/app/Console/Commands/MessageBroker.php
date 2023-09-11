<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QueueService;
use App\Services\SocialMessageService;

class MessageBroker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:Brokker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check any agent is free and message queue have any message then take message and assign agent ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $queueService    = new QueueService();
        $socialMessageService    = new SocialMessageService();
        $this->info('Message broker started...');
        while (true) {
            $this->info('Message broker Continue...');
            $queueMessageItem = $queueService->messageQueueLength();
            if($queueMessageItem){ 
                $freeAgentKey = $queueService->getFreeAgent();
                if($freeAgentKey){
                    //check any session is land in user but not responsed 
                    $messageData = $queueService->getMessageFromMessageQueue();
                    $socialMessageService->handleMessageQueueItem($freeAgentKey, $messageData);

                    $this->warn('Message Assign queue'.$freeAgentKey);
                }else{
                    $this->error('Agent Is Not Free ');
                }
                // get current all running session and check,reassign if any session is peanding in certain period of time 
                $socialMessageService->sessionIdleStatusCheckAndReassign();
                
            }else{
                $this->error('Message Not Available...');
            }
            

            sleep(5);
        }
        $this->info('Message broker End...');
    }
}

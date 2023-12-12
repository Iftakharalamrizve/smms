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
                $messageOperationInfo = $socialMessageService->queuMessageOperation();
                if($messageOperationInfo['status']){
                    $this->warn('Message Assign queue'.$messageOperationInfo['agent']);
                }else{
                    $this->error('Agent Is Not Free ');
                }                
            }else{
                $this->error('Message Not Available...');
            }
            $socialMessageService->sessionIdleStatusCheckAndReassign();
            $this->warn('Checking complete Session Idle Status');
            sleep(5);
        }
    }
}

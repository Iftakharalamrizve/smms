<?php 

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

final class HelperService{
    
    public static function lockSessionForAgent($agentId, $sessionId)
    {
        // Redis key for the hash
        $redisKey = "agent_active_service_sessions";

        // Check if the hash exists
        if (!Redis::exists($redisKey)) {
            // Create a new hash if it doesn't exist
            Redis::hset($redisKey, $agentId, json_encode([$sessionId]));
        } else {
            // Retrieve the existing hash
            $existingHash = Redis::hget($redisKey, $agentId);
            
            // Decode the JSON data or initialize an empty array if the hash doesn't contain valid JSON
            $sessionIds = json_decode($existingHash, true) ?? [];

            // Check if the session ID is not already in the list
            if (!in_array($sessionId, $sessionIds)) {
                // Add the session ID to the list
                $sessionIds[] = $sessionId;

                // Update the hash in Redis
                Redis::hset($redisKey, $agentId, json_encode($sessionIds));
            }
        }
    }

    public static function unlockSessionForAgent($agentId, $sessionId)
    {
        // Redis key for the hash
        $redisKey = "agent_active_service_sessions";

        // Check if the hash exists
        if (Redis::exists($redisKey)) {
            // Retrieve the existing hash
            $existingHash = Redis::hget($redisKey, $agentId);
            
            // Decode the JSON data or initialize an empty array if the hash doesn't contain valid JSON
            $sessionIds = json_decode($existingHash, true) ?? [];

            // Check if the session ID is in the list
            $sessionIdIndex = array_search($sessionId, $sessionIds);
            if ($sessionIdIndex !== false) {
                // Remove the session ID from the list
                unset($sessionIds[$sessionIdIndex]);

                // Update the hash in Redis
                Redis::hset($redisKey, $agentId, json_encode(array_values($sessionIds)));
            }
        }
    }

    public static function isExistInActiveServiceSession($agentId, $sessionId)
    {
        // Redis key for the hash
        $redisKey = "agent_active_service_sessions";
        // Check if the hash exists
        if (Redis::exists($redisKey)) {
            // Retrieve the existing hash
            $existingHash = Redis::hget($redisKey, $agentId);
            
            // Decode the JSON data or initialize an empty array if the hash doesn't contain valid JSON
            $sessionIds = json_decode($existingHash, true) ?? [];

            // Check if the session ID is not already in the list
            if (in_array($sessionId, $sessionIds)) {
                return true;
            }
        }
        return false;
    }

    public static function getAgentConcurrentServiceNumber()
    {
        return 4;

    }

    public static function agentChatLandMode()
    {
        return 1;

    }

    public static function getBrodcastAsAgentRoomEventName()
    {
        return "agent_chat_room_event";

    }

    public static function assignChatReRouteTime()
    {
        return 100;

    }

    public static function getMessageDurationTime()
    {
        return Carbon::now()->subMinutes(30);

    }

    public static function generateSessionId()
    {
        self::redisLog();
        $uTime = gettimeofday();
        $refId = $uTime['sec'] . $uTime['usec'];
        $refId = $refId . rand(0, 9999);
        $refId = str_pad($refId, 20, 0, STR_PAD_RIGHT);

        return $refId;
    }

    public static function currentSessionReRouteStatus($agentId, $id)
    {
        $isItemExistInActiveSessionList = self::isExistInActiveServiceSession($agentId, $id);
        if(!$isItemExistInActiveSessionList){
            $uTime = gettimeofday();
            $currentTimeStamp = $uTime['sec'];
            $sessionTimeStamp = substr($id, 0, strlen($currentTimeStamp));
            $timeDifference = $currentTimeStamp - $sessionTimeStamp;
            $reRouteDiffSecond  = self::assignChatReRouteTime();
            if($timeDifference > $reRouteDiffSecond){
                return true;
            }
            return false;
        }
        return false;
    }


    public static function redisLog(){
        $data = [];
        foreach(Redis::keys('agent_item_queue:*') as $key) {
            $info = Redis::lrange($key,0,-1);
            $data[$key] = $info[0];
        }

        $data2 = [];
        $redisKey = "agent_active_service_sessions";

        foreach([1001,1002,1003,1004] as $key) {
            $tt = json_decode(Redis::hget($redisKey,$key));
            if(is_array($tt)){
                foreach ($tt as  $v) {
                    // HelperService::unlockSessionForAgent($key,$v);
                }
            }
            $data2[$key] = Redis::hget($redisKey,$key);
        }

        $agentQueue = Redis::lrange('agent_queue', 0, -1);
        $mrrQueue = Redis::lrange('message_rr_queue',0,-1);
        $messageQueue = Redis::lrange('message_queue', 0, -1);

        self::generateApiRequestResponseLog(['Agent Queue'=> $agentQueue,'Re Rotue Queue'=> $mrrQueue, 'Message Queue' =>  $messageQueue, 'Agent Item Queue'=>$data, 'Agent Occofied Session'=>$data2]);

    }

    public static function logAgentSession($key){
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

            '----------------------------------------------------END OF SEGMENT--------------------------------------------------------------------------' . PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents ( $path.'log_' . date ( 'j.n.Y' ) . '.txt' , $log, FILE_APPEND );
    }
}
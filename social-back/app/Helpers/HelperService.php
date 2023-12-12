<?php 

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

final class HelperService{
    
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
        $uTime = gettimeofday();
        $refId = $uTime['sec'] . $uTime['usec'];
        $refId = $refId . rand(0, 9999);
        $refId = str_pad($refId, 20, 0, STR_PAD_RIGHT);

        return $refId;
    }

    public static function currentSessionReRouteStatus($id)
    {
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

            '--------------------------------------------------------------------------------------' . PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents ( $path.'log_' . date ( 'j.n.Y' ) . '.txt' , $log, FILE_APPEND );
    }
}
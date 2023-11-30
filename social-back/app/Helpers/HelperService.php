<?php 

namespace App\Helpers;

use Carbon\Carbon;

final class HelperService{
    
    public static function getAgentConcurrentServiceNumber()
    {
        return 4;

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
}
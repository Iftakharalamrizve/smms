<?php


namespace App\Helpers;
use Str;

use Auth;
use Intervention\Image\Facades\Image as Image;
use App\Models\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class Helper
{
    public static function idGenarator()
    {
        return (time() + rand(1000, 9000)) . (rand(1000,9000) + rand(10,99));
    }

    public static function getCurrentFullUrl(){
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function slugify($value)
    {

        return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $value));

    }

    public static function slugifyFullName($first_name,$middle_name='',$last_name){
        return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $first_name.' '.$middle_name.' '.$last_name));
    }

    public static function base64AvatarImageStore($url, $image)
    {
        if (!file_exists(public_path($url))) {
            mkdir(public_path($url), 777, true);
        }
        $filename = date('Ymdhis')."-".strtolower(preg_replace("/[^a-zA-Z0-9.]+/", "-", $image->getClientOriginalName()));
        Image::make($image->getRealPath())->save($url.$filename);
        return url($url.$filename);
    }

    public static function base64MediaUpload($url, $image)
    {
        $fileName = uniqid().'.'.$image->getClientOriginalExtension();
        $dir = "media/".$url."/";

        if (!file_exists(public_path ($dir))) {

            mkdir(public_path ($dir), 0755, true);

        }

        $image = Image::make($image);

        // Maximum width
        if( $image->width() > config('others.TICKET_PHOTO_MAX_WIDTH') ){

            $image = $image->resize(config('others.TICKET_PHOTO_MAX_WIDTH'), null, function ($constraint) {

                $constraint->aspectRatio();

            });

        }

        // Maximum height
        if( $image->height() > config('others.TICKET_PHOTO_MAX_HEIGHT') ){

            $image = $image->resize(null, config('others.TICKET_PHOTO_MAX_HEIGHT'), function ($constraint) {

                $constraint->aspectRatio();

            });

        }

        $image->save(public_path($dir. $fileName ));

        return url('/') . '/' . $dir . $fileName;
    }

    public static function fileUpload($url, $file)
    {
        $fileName = time().'_'.$file->getClientOriginalName();

        $dir = $url . "/";

        if (!file_exists($dir)) {

            mkdir($dir, 0755, true);

        }

        $file->move($dir, $fileName);

        return url('/') . '/' . $dir . $fileName;

    }

    public static function getClientIp() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
     * If date is valid then return ture otherwise false
     * @return Bool
     */
    public static function isDateValid($date, $format){

        $validator = Validator::make(['date' => $date], ['date' => "date|date_format:{$format}"]);
        return !$validator->fails();

    }

    public static function isDateRangeValid($startDate, $endDate):bool{
        if(strtotime($startDate) > strtotime($endDate)){// Start date is after end date
            return false;
        }
        $startDate  = Carbon::parse($startDate);
        $endDate    = Carbon::parse($endDate);
        return config('others.MAX_REPORT_DAYS') >= $startDate->diffInDays($endDate);
    }

}

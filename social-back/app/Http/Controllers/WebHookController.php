<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\WebHookService;
use App\Services\SocialMediaService;
use App\Services\SocialMessageService;
use Session;
use Auth;
use stdClass;
use Exception;

class WebHookController extends Controller
{

    private $gplexToken, $webHookService, $socialMediaService, $socialMediaMessageService;

    public function __construct()
    {

        $this->gplexToken       = config('auth.gplex_token.webhook_token');
        $this->webHookService   = new WebHookService();
        $this->socialMediaService   = new SocialMediaService();
        $this->socialMediaMessageService   = new SocialMessageService();

    }

    public function webHook(Request $request)
    {

        $this->verifyFBWebHook($this->gplexToken, $request);

        // $this->webHookDebugLog($request);

    }

    public function index(Request $request)
    {

        if(Auth::check()) {

            $data = new stdClass;

            if(Auth::user()->can('webhook-log')) {

                if(isset($request->perPage) && $request->perPage <= 150){

                    session(['perPage' => $request->perPage]);

                }

                $request->perPage       = session()->has('perPage') ? session('perPage') : config('others.ROW_PER_PAGE');
                $data->perPage          = $request->perPage;
                $data->data             = $this->webHookService->listItems($request)->data;
                $data->socialMediaList  = $this->socialMediaService->listItems()->data;

                $data->headerLink   = 'webhook-log.index';

                $request->flash();
                return view('webhook.list')->with('dataPack', $data)->withTitle('Webhook Logs');
            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    public function fbPageWebHookData(Request $request)
    {
        try {
            $type = $request->input("type");
            if($type == 'msg'){
                $content = base64_decode($request->input("contentDetails"));
                $content = json_decode($content,true)[0];
                return $this->socialMediaMessageService->processFacebookNewMessage($content)->saveAndAssignAgent(); 
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeContent($request)
    {

        $result = $this->webHookService->createItem($request);

        return $result->status;

    }


    private function verifyFBWebHook($verifyToken, $request)
    {

        if (isset($request['hub_verify_token'])) {

            if ($request['hub_verify_token'] == $verifyToken) {

                echo $request['hub_challenge']; return;

            } else {

                echo 'Invalid Verify Token';
                return;

            }
        }

    }

    private function webHookDebugLogDecode($msg)
    {
        $currentDate = date("y-m-d");
        $log_file = "/var/www/html/socialMedia2.0/webhook/{$currentDate}_webhook.log";
        if (!file_exists($log_file)){
            touch($log_file);
        }
        file_put_contents($log_file, date("y-m-d H:i:s") . " " . json_encode($msg) . "\n", FILE_APPEND | LOCK_EX);
        file_put_contents($log_file, "============================================================\n\n", FILE_APPEND | LOCK_EX);
    }

    private function webHookDebugLog($msg)
    {
        $currentDate = date("y-m-d");
        $log_file = "/var/log/webhook/{$currentDate}_webhook.log";
        if (!file_exists($log_file)){
            touch($log_file);
        }
        file_put_contents($log_file, date("y-m-d H:i:s") . " " . $msg . "\n", FILE_APPEND | LOCK_EX);
        file_put_contents($log_file, "============================================================\n\n", FILE_APPEND | LOCK_EX);
    }


    private function curlRequest($url, $request_headers = [], $post_request = false, $post_data=[])
    {

        $headers = ["cache-control: no-cache"];
        $headers = array_merge($headers, $request_headers);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($post_request) {
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response =  trim(curl_exec($ch));
        $err = curl_error($ch);

        return !empty($err) ? null : $response;
    }
}

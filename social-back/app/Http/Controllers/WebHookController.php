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
        
        $requestData = $request->input();
        //dd($requestData);
        // // $this->webHookDebugLogDecode($requestData);
        // // Generate a random number between 100 and 1000
        // $randomNumber = mt_rand(100, 1000);

        // // Create a unique key using the current time and the random number
        // $key = now()->toDateTimeString() . '-' . $randomNumber;
        //             // Fixed first key
        // $firstKey = 'sdata';

        // // Retrieve the data from the cache
        // $data = Cache::get($firstKey, []);

        // // Update the data with the variable second key and the value
        $type = $request->input("type");
        // if($type == 'msg'){
        //     $content = base64_decode($request->input("contentDetails"));
        //     $data[$key] = ["type"=> $type,,'contentDetails'=>$content];

        //     // Store the updated data back in the cache
        //     Cache::put($firstKey, $data); // Replace $minutes with your desired cache duration
        // }
        if($type == 'msg'){
            $content = base64_decode($request->input("contentDetails"));
            $content = json_decode($content,true)[0];
            return $this->socialMediaMessageService->processNewMessage($content)->saveAndAssignAgent();
        }
        // if ($requestData['object'] === 'page' && !empty($requestData['entry']) && isset($requestData['entry'][0]['messaging'])) {
            
        //     return $this->socialMediaMessageService->processNewMessage($request['entry'][0])->saveAndAssignAgent();
        // }
        $data                       = [];
        $data['pageId']             = !empty($request->entry[0]['id']) ? $request->entry[0]['id'] : '';
        $data['senderId']           = !empty($request->entry[0]['messaging'][0]['sender']['id']) ? $request->entry[0]['messaging'][0]['sender']['id'] : '';
        $data['platformTime']       = !empty($request->entry[0]['time']) ? $request->entry[0]['time'] : '';


        if(isset($request->entry)) {
           
            if(isset($request->entry[0]['changes'][0]['field']) && $request->entry[0]['changes'][0]['field']=="feed" && isset($request->entry[0]['changes'][0]['value']['item']) && $request->entry[0]['changes'][0]['value']['item']=="comment") {

                $data['content']    = !empty($request->entry) ? base64_encode(json_encode($request->entry)) : '';
                $data['type']       = 'comment';

            } else {

                if (!empty($data['senderId'] ) && !isset($request->entry[0]['messaging'][0]['read']['watermark']) && !isset($request->entry[0]['messaging'][0]['delivery']['watermark']) && $data['pageId'] != $data['senderId'] ) {
                   
                    $data['content']    = !empty($request->entry) ? base64_encode(json_encode($request->entry)) : '';
                    $data['type']       = 'msg';

                }
            }

        }

        if(isset($data['content']) && $data['content'] != NULL && $data['content'] != '') {
    
           $result = $this->storeContent($data);

           if($result == 201) {

                $socialMedia = $this->socialMediaService->getPageItem($data['pageId'])->data;

                //$this->webHookDebugLog("Social media is type: ".gettype($socialMedia));
                //$this->webHookDebugLog("Social media is data: ".$socialMedia);

                if( $socialMedia[0]->api_url) {

                    $this->webHookDebugLog("This is social api list : ".$socialMedia[0]->api_url);
                    $postData = [
                        'contentDetails'    => $data['content'],
                        'type'              => $data['type'],
                        'socialMedia'       => $socialMedia[0]
                    ];

                    $this->curlRequest($socialMedia[0]->api_url, [], true,  $postData);

                }

           }
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

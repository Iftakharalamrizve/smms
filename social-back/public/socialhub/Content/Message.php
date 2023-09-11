<?php
namespace Content;

class Message {

    private $socialPage;
    private $content;

    function __construct($socialPage, $content) {

        $this->socialPage = $socialPage;
        $this->content = $content;
    }
   

    public function conversations() {
      
        $data = json_decode(base64_decode($this->content),true);
        $page_id =  $this->socialPage->page_id;

        debug_log(__LINE__."Comes to conversation: ".$data[0]['messaging'][0]['sender']['id']); 
       
        $sender = !empty($data[0]['messaging'][0]['sender']['id']) ? $data[0]['messaging'][0]['sender']['id'] : '';
        $sender = trim($sender);

        if($page_id != '11194382') {   
    
            //send data to rasa 
            if (!empty($sender) && $page_id != $sender ) {
                
                $message = !empty($data[0]['messaging'][0]['message']['text']) ? $data[0]['messaging'][0]['message']['text'] : ''; 
                $payload = !empty($data[0]['messaging'][0]['postback']['payload']) ? $data[0]['messaging'][0]['postback']['payload'] : '';
                
                $greetMessages = ["hi","hello"]; 

                if (in_array($message, $greetMessages)) { 
                    $message = "/greet"; 
                }

                if($payload) {
                    $message = $payload; 
                } 
                
                
            
                $postData = array("page_id"=>$page_id, "sender"=>$sender."-".$page_id, "platform"=>"facebook", "message"=>$message, "metadata"=>"be", "cli"=>"");
                $postData = json_encode($postData);
                //debug_log(__LINE__." data before send: ". $data);  
                if($message) {
                    $response = $this->curlRequestChatBot('https://202.51.182.206:4436/webhooks/rest/webhook',['Content-Type: application/json'],true, $postData);
                    debug_log(__LINE__." get response from rasa: ". $response);  
                    $response = json_decode($response);
                    if($response) {
                            
                        foreach($response as $item) {
                            if($item->buttons) {
                                $buttons = array_chunk($item->buttons,3);
                                foreach($buttons as $key=>$button) { 
                                    if($key>0) {
                                        $text =($response[0]->lang=='en'?"                Or":"                অথবা");  
                                    } else {
                                        $text = $item->text;
                                    }
                                    $this->sendBotData($this->generateOptionsFromButton($sender,$button,$text));
                                }                                    
                            } else {
                                //$this->sendDataToFacebook($this->get_plain_message($item->text,$sender));
                                $plain_message = [
                                        "recipient"=> [
                                            "id"=>$sender
                                        ],
                                        "message"=> [
                                            "text"=>$item->text
                                        ]
                                    ]; 

                                
                                $this->sendBotData($plain_message); 
                            }
                        }

                        debug_log(__LINE__."I am from shopup chatbot3");        
                    }
                }
                
                exit;
                
            }
            // end send data to rasa
        }
    }


    private function curlRequestChatBot($url, $request_headers = [], $post_request = false, $post_data='') {
        
        $headers = ["cache-control: no-cache"];
        $headers = array_merge($headers, $request_headers);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        if ($post_request){
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        }
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        $response =  trim(curl_exec($ch));
        $err = curl_error($ch);
    
        return !empty($err) ? null : $response;
    }


    private function sendBotData($data) {
    
        debug_log(__LINE__."recevie from botdata function".json_encode($data));
        $this->sendReply($data);

    }


    private function sendReply($response) {

       debug_log(__LINE__." Sent response to user ResponseHelper: ". json_encode($response,true));

        $url = 'https://graph.facebook.com/v15.0/me/messages?access_token='.$this->socialPage->page_access_token;

        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS,10);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response =  trim(curl_exec($ch));
        
        $header_info = curl_getinfo($ch);
        $err = curl_error($ch);

        debug_log("FB HTTP Code ResponseHelper: ". $header_info['http_code']);
    
        return !empty($err) ? null : $response;
        exit;
    }


    private function generateOptionsFromButton($sender, $buttons, $text='') { 

        foreach ($buttons as $key=>$value) {
            $value->type="postback";
        }
        
        $options = [
            "recipient"=> [
                "id"=>$sender
            ],
            "message" => [ 
                "attachment"=> [
                    "type"=>"template",
                    "payload"=> [
                        "template_type"=>"button",
                        "text"=>$text,
                        "buttons" => $buttons
                    ]
                    
                ]
            ],
        ];
    
        return $options;
    }

}

?>
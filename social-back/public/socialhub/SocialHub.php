<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once('constant.php');
use Content;


if(isset($_REQUEST['contentDetails']) && isset($_REQUEST['socialMedia'])  && isset($_REQUEST['type'])) {
	
	$socialHub = new SocialHub($_REQUEST['contentDetails'], $_REQUEST['socialMedia'], $_REQUEST['type']);
	$socialHub->doactivity();
}

class SocialHub {
	
	private $contentDetails;
	private $socialMedia;
	private $type;
	private $coreApiUrl;
	private $apiToken;
	
	function __construct($contentDetails, $socialMedia, $type ) {
		
		$this->contentDetails = $contentDetails;
		$this->socialMedia = json_decode($socialMedia);
		$this->type = $type;
		$this->coreApiUrl = CORE_API_URL;
		$this->apiToken = API_TOKEN;
	}
	
	public function doactivity() {
		
		if($this->socialMedia->api_token==$this->apiToken) {
			
			debug_log(__LINE__."Connection Established:".$this->contentDetails); 

			switch($this->type) {

				case "msg":
					$message  = new Content\Message($this->socialMedia, $this->contentDetails);
					$message->conversations();
					break;

				case "comment":
					$postData = new Content\PostData();
					$postData->processData();
					break;
			}
			
			
		} else {
			
			debug_log(__LINE__."Unauthorized access on token: " .$this->socialMedia->api_token);  
		} 
		
		
	}
	
	// private function debug_log($msg)
	// {
	// 	$currentDate = date("y-m-d");
	// 	$log_file = "/var/www/log/webhook/{$currentDate}_social.log";
	// 	if (!file_exists($log_file)){
	// 		touch($log_file);
	// 	}
	// 	file_put_contents($log_file, date("y-m-d H:i:s") . " " . $msg . "\n", FILE_APPEND | LOCK_EX);
	// 	file_put_contents($log_file, "============================================================\n\n", FILE_APPEND | LOCK_EX);
	// }
}

 

// function debug_log($msg)
// {
	// $currentDate = date("y-m-d");
	// $log_file = "/var/www/log/webhook/{$currentDate}_social.log";
	// if (!file_exists($log_file)){
		// touch($log_file);
	// }
	// file_put_contents($log_file, date("y-m-d H:i:s") . " " . $msg . "\n", FILE_APPEND | LOCK_EX);
	// file_put_contents($log_file, "============================================================\n\n", FILE_APPEND | LOCK_EX);
// }






//$headers = array_merge($headers, $request_headers);  not needed

//$url = "192.168.70.20/fbbot/db-service/public/index.php";
//$headers = ["cache-control: no-cache"];

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt($ch, CURLOPT_TIMEOUT, 40);
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// if ($post_request){
	// curl_setopt($ch,CURLOPT_POST,true);
	// curl_setopt($ch,CURLOPT_POSTFIELDS,$_REQUEST);
// }

// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// $response =  trim(curl_exec($ch));
// $err = curl_error($ch);


// return !empty($err) ? null : $response;


?>
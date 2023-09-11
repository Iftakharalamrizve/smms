<?php
    define('CORE_API_URL', '192.168.70.20/fbbot/db-service/public/index.php');
    define('API_TOKEN', '6f9d24878484f58bce72ddeee1a1f7b5c5e68384ef67a9a66f9a8079ed326b66');

    function debug_log($msg)
	{
		$currentDate = date("y-m-d");
		$log_file = "/var/www/log/webhook/{$currentDate}_social.log";
		if (!file_exists($log_file)){
			touch($log_file);
		}
		file_put_contents($log_file, date("y-m-d H:i:s") . " " . $msg . "\n", FILE_APPEND | LOCK_EX);
		file_put_contents($log_file, "============================================================\n\n", FILE_APPEND | LOCK_EX);
	}

    spl_autoload_register(function($className) {
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/socialhub/' . $className . '.php';
    });
?>
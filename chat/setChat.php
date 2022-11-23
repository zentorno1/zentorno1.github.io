<?php

date_default_timezone_set('Europe/Moscow');

$login = urldecode($_GET['login']);
$msg = urldecode($_GET['msg']);
$message = '[' . date("H:i:s") . '] [' . $login . '] - ' . $msg;

if(file_put_contents('chat.txt', $message . "\n", FILE_APPEND))
	echo 1;
else
	echo 0;

?>
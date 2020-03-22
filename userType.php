<?php

date_default_timezone_set('Europe/Moscow');

$login = urldecode($_GET['login']);
$type = $_GET['type'];

if($type == '1')
	$msg = '[' . date("H:i:s") . '] [' . $login . '] - Вошел в "Онлайн Чат"!';
else
	$msg = '[' . date("H:i:s") . '] [' . $login . '] - Покинул "Онлайн Чат"!';

if(file_put_contents('chat.txt', $msg . "\n", FILE_APPEND))
	echo 1;
else
	echo 0;

?>
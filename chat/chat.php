<?php
	date_default_timezone_set('Europe/Kiev');
	require_once('config.php');
	
	/* 
		Oтправка сообщений
	*/ 	
	if(isset($_GET['login']) and isset($_GET['message'])) {
		$text = "[".date("H.y.s")."] [".$_GET['login']."] - ".$_GET['message']."\n";
		
		$open = file_get_contents('messages.txt'); 
		$imp = $text.$open; 
		$openFile = fopen(chat,"w"); 
		fwrite($openFile, $imp);  
		fclose($openFile); 
		if(debug == 1) echo "[Debug]: Сообщение от ".$_GET['login']." добавлено.";
	}
	
	/* 
		Oповещани¤ о входе/выходе пользователей
	*/ 	
	if(isset($_GET['login']) and isset($_GET['type'])) {
		$onConnect = "* [".date("H.y.s")."] [".$_GET['login']."] - подключилс¤ к чату \n";
		$onLeave = "* [".date("H.y.s")."] [".$_GET['login']."] - покинул чат \n";
		
		if($_GET['type'] == 1) {
			$open = file_get_contents('messages.txt'); 
			$imp = $onConnect.$open; 
			$openFile = fopen(chat,"w"); 
			fwrite($openFile, $imp);  
			fclose($openFile); 
			if(debug == 1) echo "[Debug]: Сообщение о подключении пользователя <b>".$_GET['login']."</b> добавлено.";
		} else if($_GET['type'] == 0) {
			$open = file_get_contents('messages.txt'); 
			$imp = $onLeave.$open; 
			$openFile = fopen(chat,"w"); 
			fwrite($openFile, $imp);  
			fclose($openFile); 
			if(debug == 1) echo "[Debug]: Сообщение об отключении пользователя добавлено.";
		}
	}
	
	/*
		Кто онлайн в чате
	*/
	if(isset($_GET['userLogin']) and isset($_GET['userType'])) {
		if($_GET['userType'] == 1) {
			file_put_contents('users.txt', $_GET['userLogin']."\n", FILE_APPEND);
			if(debug == 1) echo "[Debug]: Пользователь <b>".$_GET['userLogin']."</b> добавлен.";				
		}	else if($_GET['userType'] == 2) {
			$file_out = file("users.txt"); 
			for ($i=0; $i<count($file_out); $i++) { 
				if(strpos($file_out[$i], $_GET['userLogin'])!==false){
					unset($file_out[$i]);
					break;
					if(debug == 1) echo "[Debug]: Пользователь <b>".$_GET['userLogin']."</b> удален.";
				} 
			} 
			file_put_contents("users.txt", implode("", $file_out));			
		}
	}
?>
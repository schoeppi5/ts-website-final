<?php
	include("../config/login_config.php");
	
	function sendMessage($msg, $from, $to)
	{
		global $pdo;
		
		$statment = $pdo->prepare("INSERT INTO chat (from_user, to_user, msg, timestamp) VALUES (:fu, :tu, :msg, :ts)");
		$result = $statment->execute(array("fu" => $from, "tu" => $to, "msg" => $msg, "ts" => date("Y-m-d H:i:s")));
		
		return json_encode(array("state" => "success"));
	}
	
	function decodeUser($uniqueID)
	{
		global $pdo;
		
		$statment = $pdo->prepare("SELECT username FROM user WHERE uniqueID = :uid");
		$result = $statment->execute(array("uid" => $uniqueID));
		$decoded = $statment->fetch()['username'];
		return $decoded;
	}
	
	function getMessages($user1, $user2)
	{
		global $pdo;
		
		$json = array();
		
		$statment = $pdo->prepare("SELECT * FROM chat WHERE (from_user = :u1 AND to_user = :u2) OR (from_user = :u2 AND to_user = :u1) ORDER BY timestamp");
		$result = $statment->execute(array("u1" => $user1, "u2" => $user2));
		$msgcount = 0;
		while($chat = $statment->fetch())
		{
			$msgcount++;
			$json[$msgcount] = array("from_user" => $chat['from_user'], "to_user" => $chat['to_user'], "msg" => $chat['msg'], "time" => $chat['timestamp']);
		}
		
		return json_encode($json);
	}
	
	function issetAndNotEmpty($var)
	{
		if(isset($var) && !empty($var))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function errorHandler($code, $reason)
	{
		$error = array("state" => "error", "code" => $code, "reason" => $reason, "msg" => "U know what u r? A stupid fucktard for breaking this!!!");
		
		return json_encode($error);
	}
	
	if($_POST['action'] == "get")
	{
		if(issetAndNotEmpty($_POST['user']) && issetAndNotEmpty($_POST['partner']))
		{
			echo getMessages($_POST['user'], decodeUser($_POST['partner']));
		}
		else
		{
			echo errorHandler(1, "U missed some parameters");
		}
	}
	elseif($_POST['action'] == "send")
	{
		if(issetAndNotEmpty($_POST['msg']) && issetAndNotEmpty($_POST['from']) && issetAndNotEmpty($_POST['to']))
		{
			echo sendMessage($_POST['msg'], $_POST['from'], decodeUser($_POST['to']));
		}
		else
		{
			echo errorHandler(1, "U missed some parameters");
		}
	}
	else
	{
		echo errorHandler(1, "Unknown action!");
	}
?>
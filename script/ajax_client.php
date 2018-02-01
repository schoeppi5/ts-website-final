<?php
	include("../config/config.php");
	include("../config/login_config.php");
	require_once("../lib/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
	
	$wait = true;

	if($_POST['action'] == 'poke')
	{
		$uid = $_POST['uid'];
		$cid = $_POST['cid'];
		$text = $_POST['text'];
		
		$statment = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uid");
		$result = $statment->execute(array('uid' => $uid));
		$result = $statment->fetch();
		
		$username = $result['username'];
		
		try
		{
			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]."&nickname=".$username."_web");
			
			$client = $ts3_VirtualServer->clientGetById($cid);
			
			$client->poke($text);
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $username, 's' => 'INFO', 'msg' => 'Poked client: '.$client->__toString().' with message: '.$text.'!', 'ts' => date(DATE_ATOM)));
			
			header("content-type:application/json");
			$msgJson = array(
				'status' => 'success',
				'action' => $_POST['action']
			);
			echo json_encode($msgJson);
		}
		catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
		{
			header("content-type:application/json");
			$msgJson = array(
				'status' => 'error',
				'error' => "ERROR",
				'action' => $_POST['action']
			);
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $username, 's' => 'ERROR', 'msg' => 'Tried to poke client: '.$client->__toString().' with message: '.$text.'! Failed by error: '.$e, 'ts' => date(DATE_ATOM)));
			echo json_encode($msgJson);
		}
		catch(TeamSpeak3_Adapter_Exception $e)
		{
			header("content-type:application/json");
			$msgJson = array(
				'status' => 'error',
				'error' => "ERROR",
				'action' => $_POST['action']
			);
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $username, 's' => 'ERROR', 'msg' => 'Tried to poke client: '.$client->__toString().' with message: '.$text.'! Failed by error: '.$e, 'ts' => date(DATE_ATOM)));
			echo json_encode($msgJson);
		}
	}
	elseif($_POST['action'] == 'message')
	{
		$uid = $_POST['uid'];
		$cid = $_POST['cid'];
		$text = $_POST['text'];
		
		$statment = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uid");
		$result = $statment->execute(array('uid' => $uid));
		$result = $statment->fetch();
		
		$username = $result['username'];
		
		try
		{
			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]."&nickname=".$username.'&blocking=0');
			
			$client = $ts3_VirtualServer->clientGetById($cid);
			
			$client->message($text);
			
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $username, 's' => 'INFO', 'msg' => 'Send message to client: '.$client->__toString().' with message: '.$text.'!', 'ts' => date(DATE_ATOM)));
			
			$ts3_VirtualServer->notifyRegister("textprivate");
			
			TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyTextmessage", "onTextmessage");

			while($wait){
				$ts3_VirtualServer->getAdapter()->wait();
			}				
		}
		catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
		{
			header("content-type:application/json");
			$msgJson = array(
				'status' => 'error',
				'error' => "ERROR",
				'action' => $_POST['action']
			);
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $username, 's' => 'ERROR', 'msg' => 'Tried to send message to client: '.$client->__toString().' with message: '.$text.'! Failed by error: '.$e, 'ts' => date(DATE_ATOM)));
			echo json_encode($msgJson);
		}
		catch(TeamSpeak3_Adapter_Exception $e)
		{
			header("content-type:application/json");
			$msgJson = array(
				'status' => 'error',
				'error' => "ERROR",
				'action' => $_POST['action']
			);
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $username, 's' => 'ERROR', 'msg' => 'Tried to send message to client: '.$client->__toString().' with message: '.$text.'! Failed by error: '.$e, 'ts' => date(DATE_ATOM)));
			echo json_encode($msgJson);
		}
	}
	else
	{
		header("content-type:application/json");
		$msgJson = array(
			'status' => 'error',
			'error' => 'Error: Can\'t response to request(\$_POST['.$_POST['action'].']!',
			'action' => $_POST['action']
		);
		echo json_encode($msgJson);
		exit();
	}
	
	function onTextmessage(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host)
	{
		$wait = false;
		header("content-type:application/json");
		$msgJson = array(
			'status' => 'success',
			'username' => $event['invokername']->__toString(),
			'message' => $event['msg']->__toString(),
			'action' => $_POST['action']
		);
		echo json_encode($msgJson);
		exit();
	}
?>
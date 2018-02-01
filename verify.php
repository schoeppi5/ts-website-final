<?php
	include("header.php");
	include("include/nav.php");
	
	function valKey($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	if(isset($_GET['key']))
	{
		$statement = $pdo->prepare("SELECT * FROM pending WHERE validation_key = :vk");
		$result = $statement->execute(array('vk' => $_GET['key']));
		$user = $statement->fetch();
		
		if($user)
		{
			$uname = $user['username'];
			$mail = $user['email'];
			$pw = $user['password'];
			$statement = $pdo->prepare("INSERT INTO user (cuid, email, username, power, uniqueID) VALUES (:cuid, :email, :uname, :power, :uid)");
			$result = $statement->execute(array('cuid' => $user['cuid'], 'email' => $mail, 'uname' => $uname, 'power' => $user['power'], 'uid' => valKey(20)));
			$statement = $pdo->prepare("INSERT INTO passwd (username, password) VALUES (:uname, :pw)");
			$result = $statement->execute(array('uname' => $uname, 'pw' => $pw));
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $uname, 's' => 'INFO', 'msg' => 'Created useraccount with power: '.$user['power'].' and cuid: '.$user['cuid'], 'ts' => date(DATE_ATOM)));
			$statement = $pdo->prepare("DELETE FROM pending WHERE validation_key = :vk");
			$result = $statement->execute(array(':vk' => $_GET['key']));
			
			echo '<span id="pending" >'.$config["general"]["verify_success"].'</span>';
			//logging in
			$_SESSION["userID"] = $user["uniqueID"];
		}
		else
		{
			echo '<span id="pending-error">'.$config["error"]["key_not_found"].'</span>';
		}
	}
	else
	{
		header ("Location:./index.php");
	}
?>
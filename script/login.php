<?php
	$error = "nothing";
	
	if(isset($_GET['login'])){
		$email = $_POST['email'];
		$password = $_POST['pass'];
		
		$statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();
		
		if($user !== false){
			$statement = $pdo->prepare("SELECT * FROM passwd WHERE username = :uname");
			$result = $statement->execute(array('uname' => $user['username']));
			$pw = $statement->fetch();
			if(password_verify($password, $pw['password'])){
				$_SESSION['userID'] = $user['uniqueID'];
				if($_POST['remember'])
				{
					setcookie('userID', $_SESSION['userID'], time() + (365 * 24 * 60 * 60));
				}
				else
				{
					if(isset($_COOKIE['userID']) && !empty($_COOKIE['userID']))
					{
						unset($_COOKIE['userID']);
					}
				}
				//log
				$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
				$result = $statement->execute(array('uname' => $user['username'], 's' => 'INFO', 'msg' => 'Logged in', 'ts' => date(DATE_ATOM)));
			}
			else {
				$error = "pass";
			}
		}
		else 
		{
			$error = "mail";
		}
	}
	elseif(isset($_GET['logout'])){
		//log
		$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uid");
		$result = $statement->execute(array("uid" => $_SESSION['userID']));
		$user = $statement->fetch();
		$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
		$result = $statement->execute(array('uname' => $user['username'], 's' => 'INFO', 'msg' => 'Logged out', 'ts' => date(DATE_ATOM)));
		session_destroy();
		if(isset($_COOKIE['userID']) && !empty($_COOKIE['userID']))
		{
			echo "Unset cookie!";
			setcookie('userID', null, -1);
		}
		header("location:index.php");
	}
	elseif(isset($_SESSION['userID'])){
		$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
		$result = $statement->execute(array('uname' => $_SESSION['userID']));
		$user = $statement->fetch();
		
		if($user == false){
			unset($user);
			session_destroy();
		}
	}
	else
	{
		$error = "nothing";
	}
?>
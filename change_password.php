<?php
	include("config/login_config.php");
	include("header.php");
	include("include/nav.php");
	
	$error = false;
	$errorold = false;
	$errornew = false;
	$errormpw = false;
	$errornomail = false;
	$success = false;
	$errorend = false;
	
	if(isset($_GET['change'])){
		$old = $_POST['old'];
		$new = $_POST['new'];
		$new2 = $_POST['new2'];
		
		if(strlen($old) == 0){
			$errorold = true;
			$error = true;
		}
		if(strlen($new) < 8){
			$errornew = true;
			$error = true;
		}
		if(strcmp($new, $new2) !== 0){
			$errormpw = true;
			$error = true;
		}
		
		if(!$error){
			$uname = $_SESSION['userID'];
			$statement = $pdo->prepare("SELECT * FROM user WHERE username = :uname");
			$result = $statement->execute(array('uname' => $uname));
			$user = $statement->fetch();
			
			if($user == false){
				$errornomail = true;
				$error = true;
			}
			
			if(!$error){
				$statement = $pdo->prepare("UPDATE passwd SET password = :pw WHERE username = :uname");
				$pw_hash = password_hash($new, PASSWORD_DEFAULT);
				$result = $statement->execute(array('pw' => $pw_hash, 'uname' => $uname));
			
				if($result){
					//log
					$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
					$result = $statement->execute(array('uname' => $user['username'], 's' => 'INFO', 'msg' => 'Changed password', 'ts' => date(DATE_ATOM)));
					$success = true;
				}
			}
		}
	}
?>
		<div class="container noselect">
			<div class="register">
				<?php 
				if(isset($_SESSION['userID']) && !$success){
					include('include/change_form.php');
				}
				elseif($success){
					echo '<p>'.$config["general"]["change_success"].'</p>';
				}
				else
				{
					echo '<p>'.$config["error"]["change_error"].'</p>';
				}
				?>
			</div>
		</div>
<?php
	include("include/footer.php");
?>
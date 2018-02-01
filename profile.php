<?php
	include("header.php");
	include("include/nav.php");
	
	$error_mail = false;
	
	if(!isset($_SESSION['userID'])){
		header("location:index.php");
	}
	if(isset($_GET['username'])){
		$statement = $pdo->prepare("UPDATE user SET username = :uname WHERE username = :username");
		$result = $statement->execute(array('uname' => $_POST['uname'], 'username' => $_SESSION['userID']));
		$statement = $pdo->prepare("UPDATE passwd SET username = :uname WHERE username = :username");
		$result = $statement->execute(array('uname' => $_POST['uname'], 'username' => $_SESSION['userID']));
		$statement = $pdo->prepare("UPDATE log SET username = :uname WHERE username = :username");
		$result = $statement->execute(array('uname' => $_POST['uname'], 'username' => $_SESSION['userID']));
		$statement = $pdo->prepare("UPDATE chat SET from_user = :uname WHERE from_user = :username");
		$result = $statement->execute(array('uname' => $_POST['uname'], 'username' => $_SESSION['userID']));
		$statement = $pdo->prepare("UPDATE chat SET to_user = :uname WHERE to_user = :username");
		$result = $statement->execute(array('uname' => $_POST['uname'], 'username' => $_SESSION['userID']));
		//log
		$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
		$result = $statement->execute(array('uname' => $_POST['uname'], 's' => 'WARNING', 'msg' => 'Changed username from: '.$_SESSION['userID'].' to: '.$_POST['uname'].'!', 'ts' => date(DATE_ATOM)));
		$_SESSION['userID'] = $_POST['uname'];
		
		$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
		$result = $statement->execute(array('uname' => $_SESSION['userID']));
		$user = $statement->fetch();
		
		header("location:profile.php");
		
		if($user == false){
			unset($user);
			session_destroy();
			header("location:index.php");
		}
	}
	if(isset($_GET['email'])){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$statement = $pdo->prepare("UPDATE user SET email = :mail WHERE username = :username");
			$result = $statement->execute(array('mail' => $_POST['email'], 'username' => $_SESSION['userID']));
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $_SESSION['userID'], 's' => 'WARNING', 'msg' => 'Changed email to: '.$_POST['email'].'!', 'ts' => date(DATE_ATOM)));
			$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
			$result = $statement->execute(array('uname' => $_SESSION['userID']));
			$user = $statement->fetch();
			
			header("location:profile.php");
			
			if($user == false){
				unset($user);
				session_destroy();
				header("location:index.php");
			}
		}
	}
?>
	<div class="container con-profile">
		<div class="profile-info">
			<h1><?php echo $config["general"]["profile"]?></h1>
			<article>
				<div class="userdata-con"><p><?php echo $config["general"]["username"]?>:</p><?php if(isset($_SESSION['userID']) && isset($user['username'])){echo '<p id="uname" class="userdata">'.$user['username'].'</p>';}else {echo '<p class="error userdata">'.$config["error"]["data"].'</p>';}?>
				<form action="?username" method="post" id="uname-form" class="userdata-form" style="display: none;"><input id="uname-input" name="uname" class="userdata-input" type="text" maxlength="255" /><button class="userdata-button" disabled><?php echo $config["interaction"]["change"] ?></button></form></div>
				
				<div class="userdata-con"><p><?php echo $config["general"]["email"] ?>:</p><?php if(isset($_SESSION['userID']) && isset($user['email'])){echo '<p id="email_data" class="userdata">'.$user['email'].'</p>';}else {echo '<p class="error userdata">'.$config["error"]["data"].'</p>';}?>
				<form action="?email" method="post" id="email_data-form" class="userdata-form" style="display: none;"><input id="email_data-input" name="email" class="userdata-input" type="email" maxlength="255" /><button class="userdata-button" disabled><?php echo $config["interaction"]["change"] ?></button></form></div>
				
				<div class="userdata-con"><p><?php echo $config["general"]["uid"] ?>:</p><?php if(isset($_SESSION['userID']) && isset($user['cuid'])){echo '<p id="cuid_data" class="userdata">'.$user['cuid'].'</p>';}else {echo '<p class="error userdata">'.$config["error"]["data"].'</p>';}?></div>
		</div>
		<?php
			if(intval($user['power']) >= 3)
			{
		?>
		<div class="profile-info">
			<h1><?php echo $config["general"]["log"] ?>:<img src="images/reload.gif" style="display: none;" /></h1>
			<table id="log" >
			</table>
			<button onclick="deleteLog()"><?php echo $config["interaction"]["clear_log"] ?></button>
		</div>
		<?php
			}
		?>
	</div>
	<script>
		$(document).ready(function(){
			$("#uname").click(function(){changeOnClick(this)});
			$("#uname-input").on("change keyup paste", function(){enableButton(this)});
			$("#email_data").click(function(){changeOnClick(this)});
			$("#email-input").on("change keyup paste", function(){enableButton(this)});
			reload();
		});
		
		function deleteLog()
		{
			$.ajax(
			{
				url: './script/ajax_db.php',
				type: 'post',
				data: {'cmd': 'deleteAll'},
				success: function(content)
				{
					if(content == "success")
					{
						console.log('deleted successfully');
					}
					else
					{
						console.log("error");
					}
				},
				error: function(xhr, desc, err)
				{
					console.log(xhr),
					console.log("Details: " + desc + "\nError:" + err);
				}
			});
			reload();
		}

		function deleteLogEntry(a)
		{
			var ts = $(a).find('.time').html();
			$.ajax(
			{
				url: './script/ajax_db.php',
				type: 'post',
				data: {'cmd': "delete", 'ts': ts},
				success: function(content)
				{
					if(content == "success")
					{
						console.log('deleted successfully');
					}
					else
					{
						console.log("error");
					}
				},
				error: function(xhr, desc, err)
				{
					console.log(xhr),
					console.log("Details: " + desc + "\nError:" + err);
				}
			});
			reload();
		}
		
		function reload()
		{
			$('.profile-info h1 img').show();
			$('#log').load('./include/log.php', function()
			{
				$('.profile-info h1 img').hide();
			});
		}
		
		function changeOnClick(p){
			$(p).hide();
			var input = "#" + $(p).attr("id") + "-input";
			$(input).attr("placeholder", $(p).text());
			$(input).parent().show();
		}
		function enableButton(p){
			if ($(p).val() !== "") {
				$(p).parent().find(":button").prop('disabled', false);
			}
			else
			{
				$(p).parent().find(":button").prop('disabled', true);
			}
		}
	</script>
<?php
	include("include/footer.php");
?>
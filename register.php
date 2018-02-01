<?php
	include("config/login_config.php");
	include("header.php");
	include("include/nav_nologin.php");
	
	$error = false;
	$errormail = false;
	$errormailex = false;
	$errorunameex = false;
	$errorpw = false;
	$errormpw = false;
	$erroruname = false;
	$success = false;
	$errorend = false;
	$errorcuid = false;
	$errorpow = false;
	$keyValWait = false;
	
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
	
	if(isset($_GET['register'])){
		$email = $_POST['email'];
		$uname = $_POST['uname'];
		$passwd = $_POST['passwd'];
		$passwd2 = $_POST['passwd_repeat'];
		$cuid = $_POST['cuid'];
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errormail = true;
			$error = true;
		}
		if(strlen($uname) == 0){
			$erroruname = true;
			$error = true;
		}
		if(strlen($passwd) < 8){
			$errorpw = true;
			$error = true;
		}
		if(strcmp($passwd, $passwd2) !== 0){
			$errormpw = true;
			$error = true;
		}
		
		if(!$error){
			$statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
			$result = $statement->execute(array('email' => $email));
			$user = $statement->fetch();
			
			if($user !== false){
				$errormailex = true;
				$error = true;
			}
			
			$statement = $pdo->prepare("SELECT * FROM user WHERE username = :uname");
			$result = $statement->execute(array('uname' => $uname));
			$user = $statement->fetch();
			
			if($user !== false){
				$errorunameex = true;
				$error = true;
			}
		}
		
		if(!$error)
		{			
			try
			{	
				$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
				$valKey_poke = valKey(10);
				
				$pw_hash = password_hash($passwd, PASSWORD_DEFAULT);
				
				$power = 0;
				
				foreach($ts3_VirtualServer->clientGetByUid($cuid)->memberOf() as $ts3_group)
				{
					if($ts3_group->getUniqueId() == $ts3_VirtualServer->serverGroupGetById($config["ts"]["adminGroupId"])->getUniqueId())
					{
						$power = 3;
					}
					elseif($ts3_group->getUniqueId() == $ts3_VirtualServer->serverGroupGetById($config["ts"]["moderatorGroupId"])->getUniqueId())
					{
						$power = 2;
					}
					elseif($ts3_group->getUniqueId() == $ts3_VirtualServer->serverGroupGetById($config["ts"]["memberGroupId"])->getUniqueId())
					{
						$power = 1;
					}
				}
				
				if($power == 0)
				{
					$errorpow = true;
					$error = true;
				}
					
				if(!$error && !$keyValWait)
				{
					$ts3_VirtualServer->clientGetByUid($cuid)->poke("Please enter this Key in order to proceed your registration process: ".$valKey_poke);
					$keyValWait = true;
					
					$statement = $pdo->prepare("INSERT INTO pending_ts (cuid, email, username, password, validation_key, power) VALUES (:cuid, :email, :uname, :pw, :vk, :power)");
					$result = $statement->execute(array('cuid' => $cuid, 'email' => $email, 'uname' => $uname, 'pw' => $pw_hash, 'vk' => $valKey_poke, 'power' => $power));
				}
			}
			catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
			{
				//die("Error " . $e->getCode() . ": " . $e->getMessage() . "Please contact the webmaster on admin@suchtclub.de to report this buck!");
				$errorcuid = true;
			}
			catch(TeamSpeak3_Exception $e)
			{
				$errorcuid = true;
				$errorcuid_e = $e;
			}
		}
	}
		
	if(isset($_GET['valKey']))
	{
		$valKey_ts = $_GET['valKey'];
		
		$statement = $pdo->prepare("SELECT * FROM pending_ts WHERE validation_key = :vk");
		$result = $statement->execute(array('vk' => $valKey_ts));
		$user = $statement->fetch();
		
		if($user)
		{
			$validation_key = valKey(20);
			
			$statement = $pdo->prepare("INSERT INTO pending (cuid, email, username, password, power, validation_key) VALUES (:cuid, :email, :uname, :pw, :power, :vk)");
			$result = $statement->execute(array('cuid' => $user['cuid'], 'email' => $user['email'], 'uname' => $user['username'], 'pw' => $user['password'], 'power' => $user['power'], 'vk' => $validation_key));
			
			if($result){
				$success = true;
				$statement = $pdo->prepare("DELETE FROM pending_ts WHERE validation_key = :vk");
				$result = $statement->execute(array(':vk' => $user['validation_key']));
				header ("Location:./pending.php?key=".$validation_key);
			}
			else
			{
				$errorend = true;
			}
		}
	}
?>
		<div class="container noselect">
			<div class="register">
			<?php
				if($keyValWait == false)
				{
					?>
					<form action="?register" method="post">
						<ul id="reg_form">
							<li>
								<h3><?php echo $config["general"]["register"] ?></h3>
							<li>
								<label for="email"><?php echo $config["general"]["email"] ?>:</label><br />
								<?php if(!$errormail && !$errormailex){?><input type="email" id="email" name="email" /><?php } else {?><input type="text" id="email" name="email" style="border-color: #ed1515" placeholder=<?php if($errormail){echo '"'.$config["error"]["email_invalid"].'" />';} else {echo '"'.$config["error"]["email_invalid"].'" />';}}?><br />
							</li>
							<br />
							<li>
								<label for="uname"><?php echo $config["general"]["username"] ?>:</label><br />
								<?php if(!$erroruname && !$errorunameex){?><input type="text" name="uname" id="uname" /><?php } else {?><input type="text" name="uname" id="uname" style="border-color: #ed1515" placeholder=<?php if($erroruname){echo '"'.$config["error"]["no_username"].'" />';} else {echo'"'.$config["error"]["email_used"].'" />';}}?><br />
							</li>
							<br />
							<li>
								<label for="passwd"><?php echo $config["general"]["password"] ?>:</label><br />
								<?php if(!$errorpw && !$errormpw){?><input type="password" name="passwd" id="passwd" /><?php } else {?><input type="password" name="passwd" id="passwd" style="border-color: #ed1515" placeholder=<?php if($errorpw){echo '"'.$config["error"]["password_length"].'" />';} else {echo'"'.$config["erro"]["password_mismatch"].'" />';}}?><br />
							</li>
							<br />
							<li>
								<label for="passwd_repeat"><?php echo $config["general"]["password_repeat"] ?>:</label><br />
								<?php if(!$errormpw){?><input type="password" name="passwd_repeat" id="passwd_repeat" /><?php } else {?><input type="password" name="passwd_repeat" id="passwd_repeat" style="border-color: #ed1515" placeholder=<?php echo '"'.$config["erro"]["password_mismatch"].'" />';}?><br />
							</li>
							<br />
							<li>
								<label for="cuid" title="<?php echo $config["interaction"]["uid_verify"] ?>"><?php echo $config["general"]["uid_enter"] ?>:</label><a class="questionmark" title="<?php echo $config["interaction"]["tip_uid"] ?>" tabindex="-1">?</a><br />
								<?php if(!$errorcuid && !$errorpow)
								{
									?><input type="text" name="cuid" id="cuid" /><?php 
								}
								else 
								{
									?><input type="text" name="cuid" id="cuid" style="border-color: #ed1515" placeholder=
								<?php 
									if($errorcuid)
									{
										echo '"'.$config["error"]["uid_not_online"].'" />';
									}
									else
									{
										$groupName = "Unknown";
										try
										{
											$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
											
											$groupName = $ts3_VirtualServer->serverGroupGetById($config["ts"]["memberGroupId"])->__toString();
										}
										catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
										{
											$groupName = $config["error"]["ts_communication"];
										}
										if($groupName != $config["error"]["ts_communication"])
										{
											echo '"You have to be at least ' . $groupName . ' to be able to join our Website!" />';
										}
										else
										{
											echo '"'.$groupName.'"';
										}
									}
								}
								?>
							<br />
							</li>
							<br />
							<li>
								<button><?php echo $config["interaction"]["register_btn"] ?></button>
							</li>
						</ul>
					</form>
					<?php
				}
				else
				{
					?>
					<form action="?key" method="get">
						<ul id="reg_form">
							<li>
								<h3><?php echo $config["general"]["validation_key"] ?>:</h3>
							</li>
							<br />
							<li>
								<input type="text" name="valKey" id="valKey" style="width: 100%" placeholder="<?php if($errorend == true){echo "Ups! That should not have happend!";} ?>"/>
							</li>
							<br />
							<li>
								<button><?php echo $config["interaction"]["register_btn"] ?></button>
							</li>
						</ul>
					</form>
					<?php
				}
				?>
			</div>
		</div>
<?php
	include("include/footer.php");
?>
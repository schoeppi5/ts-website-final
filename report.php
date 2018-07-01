<?php
	include("header.php");
	include("./include/nav.php");
	
	$errorName = false;
	$errorSame = false;
	
	$from = "";
	$fromName = "";
	$reason = "";
	$concernUser = "";
	$msg = "";
	
	function isNotEmpty($var)
	{
		return isset($var) && !empty($var);
	}
	
	if(isset($_POST['reason']))
	{
		if(!isNotEmpty($_POST['name']))
		{
			$errorName = true;
		}
		elseif(!isset($_POST['name']['cuid']))
		{
			$form = $_POST['name'];
			$fromName = $_POST['name'];
		}
		else
		{
			try
			{
				$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
				$clients = $ts3_VirtualServer->clientListDb(0, $ts3_VirtualServer->clientCountDb());
				$clientIdentity = $config["error"]["user_unknown"];
				foreach($clients as $client)
				{
					if($client['client_unique_identifier'] == $_POST['name']['cuid'])
					{
						$clientIdentity = htmlspecialchars($client['client_nickname']);
					}
				}
				$from = "Name: ".$_POST['name']['name']."/ CUID: ".$_POST['name']['cuid']."/ TeamSpeak Identitiy: ".$clientIdentity;
				$fromName = $_POST['name']['name'];
			}
			catch(Exception $e)
			{
				$form = "Name: ".$_POST['name']['name']."/ CUID: ".$_POST['name']['cuid'];
				$fromName = $_POST['name']['name'];
			}
		}
		
		$reason = $_POST['reason'];
		
		$concern = explode(",", $_POST['concerning']);
		
		if(isset($_POST['name']['cuid']))
		{
			if($_POST['name']['cuid'] == $concern[0])
			{
				$errorSame = true;
				echo '<div id="errorSame" class="clickable">'.$config["error"]["self_report"].'</div>';
			}
			else
			{
				$concernUser = $concern[1].'/ CUID: '.$concern[0];
			}
		}
		
		if(isNotEmpty($_POST['annotation']))
		{
			$msg = $_POST['annotation'];
		}
		
		if(!$errorSame && !$errorName)
		{
			try
			{
				$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
				$admins = $ts3_VirtualServer->serverGroupClientList($config["ts"]["adminGroupId"]);
				$reportedTo = "Reported to:";
				foreach($admins as $admin)
				{
					if($admin['client_unique_identifier'] !== $concern[0])
					{
						try
						{
							$adminPoke = $ts3_VirtualServer->clientGetByUid($admin['client_unique_identifier']);
							$adminPoke->poke($form.' has reported '.$concernUser.'! An E-Mail with more details was send to admin@suchtclub.de');
							$reportedTo .= ' '.$admin['client_nickname'];
						}
						catch(Exception $e)
						{
							$reportedTo .= ' NOT '.$admin['client_nickname'];
						}
					}
					else
					{
						$reportedTo .= ' EXCLUDED '.$admin['client_nickname'];
					}
				}
			}
			catch(Exception $e)
			{
			}
			
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $fromName, 's' => 'REPORT', 'msg' => 'Reported: '.$concern[1].' for reason: '.$reason.'!', 'ts' => date(DATE_ATOM)));
			
			
			$mailtext = '<html>
					<head>
						<title>Report!</title>
					</head>
				 
					<body>
				 
						<h1>From'.$from.'</h1>
					 
						<p>Reported: '.$concernUser.' for: '.$reason.'</p>
						
						<p>'.$msg.'</p>
					 
						<p>'.$reportedTo.'</p>
				 
					</body>
				</html>
			';
			
			$mailtext = wordwrap($mailtext, 70);
			 
			$mailto 	= "admin@suchtclub.de";
			$from		= "admin@suchtclub.de";
			$subject    = "Report from ".$fromUser;
			 
			$header  = "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html; charset=utf-8\r\n";
			 
			$header .= "From: $from\r\n";
			// $header .= "Cc: $cc\r\n";  //in case cc wanted
			$header .= "X-Mailer: PHP ". phpversion();
			 
			mail( $mailto,
				  $subject,
				  $mailtext,
				  $header);
			
			echo '<div id="thanks" class="clickable">'.$config["general"]["report_thanks"].'</div>';
		}
		
	}
?>
<div class="report">
	<h1><?php echo $config["general"]["report_title"]?></h1>
	<form action="report.php" method="post">
		<label for="name"><?php echo $config["general"]["report_name"]?></label>
		<?php
			if(isset($_SESSION['userID']))
			{
				echo '<input type="text" id="name" name="name[name]" value="'.$user['username'].'" readonly/>';
				echo '<input type="hidden" name="name[cuid]" value="'.$user['cuid'].'" />';
			}
			else
			{
				if($errorName)
				{
					echo '<input type="text" id="name" name="name" value="" class="errorInput" placeholder="'.$config["general"]["report_name_holder"].'"/>';
				}
				else
				{
					echo '<input type="text" id="name" name="name" value="" placeholder="'.$config["general"]["report_name_holder"].'"/>';
				}
			}
		?>
		<br />
		<br />
		<label for="reason"><?php echo $config["general"]["report_reason"]?></label>
		<select name="reason" id="reason">
			<option><?php echo $config["general"]["reason_1"]?></option>
			<option><?php echo $config["general"]["reason_2"]?></option>
			<option><?php echo $config["general"]["reason_3"]?></option>
			<option><?php echo $config["general"]["reason_4"]?></option>
		</select>
		<label for="concerning"><?php $config["general"]["report_concern"]?></label>
		<?php
		try
		{
			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
			$clients = $ts3_VirtualServer->clientListDb(0, $ts3_VirtualServer->clientCountDb());
			echo '<select id="concerning" name="concerning">';
			foreach($clients as $client)
			{
				if(isNotEmpty($client['client_unique_identifier']) && isNotEmpty($client['client_nickname']))
				{
					if(strpos(htmlspecialchars($client['client_nickname']), "REST API #") == false)
					{
						echo '<option value="'.$client['client_unique_identifier'].', '.htmlspecialchars($client['client_nickname']).'">'.htmlspecialchars($client['client_nickname']).'</option>';
					}
				}
			}
			echo '</select>';
		}
		catch(Exception $e)
		{
			echo '<input type="text" id="concerning" name="concerning" placeholder="'.$config["general"]["concern_holder"].'" />';
		}
		?>
		<label for="annotation"><?php echo $config["general"]["report_annotation"]?></label>
		<textarea rows="5" id="annotation" name="annotation" placeholder="<?php echo $config["general"]["annotation_holder"]?>"></textarea>
		<button type="submit" value="report"><?php echo $config["interaction"]["report_submit"]?></button>
	</form>
	<script>
		$('.clickable').click(function()
		{
			$(this).slideUp(300);
		});
	</script>
</div>
<?php
	include("include/footer.php");
?>
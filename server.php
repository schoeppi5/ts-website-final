<link rel="stylesheet" href="style/info.css" type="text/css" />
<?php
	include("header.php");
	include("./custom/custom.php");
	
	if(!isset($_SESSION['userID']))
	{
		die('<h1>'.$config["error"]["log_in_to_view"].'</h1>');
	}
	
	$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
	$result = $statement->execute(array('uname' => $_SESSION['userID']));
	$user = $statement->fetch();
	
	if(!$user)
	{
		die('<h1>'.$config["error"]["account_deleted"].'</h1>');
	}
	
	$power = intval($user['power']);
	
	if($power < 2)
	{
		die('<h1>'.$config["error"]["insufficient_power"].'<h1>');
	}
	
	if(isset($_GET['stop']))
	{
		try
		{
			$server = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
			
			$server->stop();
			
			//log
			$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
			$result = $statement->execute(array('uname' => $user['username'], 's' => 'WARNING', 'msg' => 'Stopped virtual server: '.$sid, 'ts' => date(DATE_ATOM)));
			
			die('<h1>'.$config["general"]["server_stopped"].'</h1>');
		}
		catch(TeamSpeak3_Adapter_Exception $e)
		{
			die('<h1>'.$config["error"]["ts_communication"].'</h1>');
		}
	}
	elseif(isset($_GET['start']))
	{
		try
		{
			$server = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"].'#use_offline_as_virtual');
			
			$server->start();
			
			die('<h1>'.$config["general"]["server_started"].'</h1>');
		}
		catch(TeamSpeak3_Adapter_Exception $e)
		{
			die('<h1>'.$config["error"]["ts_communication"].'</h1>');
		}
	}
	elseif(isset($_GET['sid']))
	{
		try
		{
			$sid = $_GET['sid'];
			
			$server = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
			
		}
		catch(TeamSpeak3_Adapter_Exception $e)
		{
			die('<h1>'.$config["error"]["ts_communication"].'</h1>');
		}
?>

<div class="container">
	<h1><?php echo $config["general"]["server_topic"].' '.$server['virtualserver_name']?></h1>
	<table>
		<tr>
			<td><?php echo $config["general"]["server_welcome"]?></td>
			<td><?php echo $server['virtualserver_welcomemessage']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["server_version"]?></td>
			<td><?php echo $server['virtualserver_version']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["server_clients"]?></td>
			<td><?php echo ($server['virtualserver_clientsonline'] - 1) . "/" . $server['virtualserver_maxclients']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["server_platform"]?></td>
			<td><?php echo $server['virtualserver_platform']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["server_created"]?></td>
			<td><?php echo date("d.m.Y\ H:i:s\ ", $server['virtualserver_created'])?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["server_uptime"]?></td>
			<td id="uptime"></td>
		<tr>
			<td><?php echo $config["general"]["server_global_id"]?></td>
			<td><?php echo $server['virtualserver_unique_identifier']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["server_hostbanner"]?></td>
			<td><?php echo '<img src="'.$server['virtualserver_hostbanner_gfx_url'].'" title="'.$server['virtualserver_hostbanner_url'].'" />';?></td>
		</tr>
	</table>
	<script>
		$('document').ready(function()
		{
			$('#uptime').load("./include/getDiff.php");
			var getdiff = setInterval(function(){$('#uptime').load("./include/getDiff.php");}, 60000);
		});
	</script>
	<br />
	<?php
		if($power >= 3)
		{
		?>
		<div class="admin noselect">
			<h1><?php echo $config["general"]["action"]?></h1>
			<button onclick="window.location.href='?stop'" class="ctrl-btn"><?php echo $config["interaction"]["server_stop"]?></button>
		</div>
		<?php
		}
	?>
</div>
<?php
	}
?>
		
<link rel="stylesheet" href="style/info.css" type="text/css" />
<?php
	include("header.php");
	include("lib/custom/custom.php");

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
	
	if(isset($_GET['clid']))
	{
		$clid = $_GET['clid'];
		$name = "Unknown";
		
		try
		{
			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]."&nickname=".$user['username']);
			
			$channel = $ts3_VirtualServer->channelGetById($clid);
			
			if(isset($_GET['delete']))
			{
				try
				{
					$channel->delete(true);
					die('<h1>'.$config["general"]["channel_deleted"].'</h1>');
				}
				catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
				{
					die('<h1>'.$config["error"]["channel_del_failed"].'</h1>');
				}
								
			}
			
			if(isset($_GET['msg']))
			{
				try
				{
					if(isset($_POST['msg']) && !empty($_POST['msg']))
					{
						$channel->message($_POST['msg']);
					}
				}
				catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
				{
					die('<h1>'.$config["error"]["channel_msg_failed"].'</h1>');
				}
								
			}
			
			$name = $channel['channel_name'];
			
		}
		catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
		{
			die('<h1>'.$config["error"]["channel_not_found"].'</h1>');
		}
		catch(TeamSpeak3_Adapter_Exception $e)
		{
			die('<h1>'.$config["error"]["ts_communication"].'</h1>');
		}
?>
<div class="se-pre-con"></div>
<script>
	$(window).on('load', function()
	{
		$('.se-pre-con').fadeOut(500);
	});
</script>
<div class="container">
	<h1><?php echo $config["general"]["channel_info"] ?>:
		<?php 
			echo $name;
			if($channel['channel_flag_password']){echo ' &#x1f512;';}
		?>
	</h1>
	<table>
		<tr>
			<td><?php echo $config["general"]["channel_topic"] ?>:</td>
			<td><?php echo $channel['channel_topic']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["channel_desc"] ?>:</td>
			<td><?php echo $channel['channel_description']?></td>
		<tr>
			<td><?php echo $config["general"]["channel_duration"] ?>:</td>
			<td><?php if($channel['channel_flag_permanent']){echo 'Permanent';}elseif($channel['channel_flag_semi_permanent']){echo 'Semi permanent';}else{echo 'Temporary';}?></td>
		</tr>
			<td><?php echo $config["general"]["channel_codec"] ?>:</td>
			<td>
				<?php
					switch($channel['channel_codec'])
					{
						case TeamSpeak3::CODEC_CELT_MONO :
							echo 'celt mono (mono, 16bit, 48kHz)';
							break;
						case TeamSpeak3::CODEC_OPUS_MUSIC :
							echo 'opus music (interactive)';
							break;
						case TeamSpeak3::CODEC_OPUS_VOICE :
							echo 'opus voice (interactive)';
							break;
						case TeamSpeak3::CODEC_SPEEX_NARROWBAND :
							echo 'speex narrowband (mono, 16bit, 8kHz)';
							break;
						case TeamSpeak3::CODEC_SPEEX_ULTRAWIDEBAND :
							echo 'speex ultra-wideband (mono, 16bit, 32kHz)';
							break;
						case TeamSpeak3::CODEC_SPEEX_WIDEBAND :
							echo 'speex wideband (mono, 16bit, 16kHz)';
							break;
						default :
							echo 'unable to detect codec!';
					}
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["channel_icon"] ?>:</td>
			<td><?php echo getImageChannel($channel);?></td>
		<tr>
			<td><?php echo $config["general"]["channel_talkpow"] ?>:</td>
			<td><?php echo $channel['channel_needed_talk_power'];?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["channel_max_client"] ?>:</td>
			<td><?php if($channel['channel_flag_maxclients_unlimited']){echo 'unlimited';}else{echo $channel['channel_maxclients'];}?></td>
		</tr>
	</table>
	<?php
		if($power >= 2)
		{
	?>
		<div class="admin noselect">
			<h1><?php echo $config["general"]["action"]	?></h1>
			<ul>
				<li><button style="float: right;" class="hamburger hamburger--collapse" type="button" id="dropbtn"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button></li>
				<?php
					if($power >= 3)
					{
				?>
				<li class="drop">
					<span title="Delete <?php echo $name?>" onclick="deleteChannel()"><?php echo $config["interaction"]["channel_delete"] ?></span>
					<script>
						function deleteChannel()
						{
							if(confirm("<?php echo $config["interaction"]["channel_del_ok"] ?>"))
							{
								window.location.assign("?clid=<?php echo $clid?>&delete=true");
							}
						}
					</script>
				</li>
				<?php
					}
				?>
				<li class="drop">
					<span class="form-drop" title="Message to <?php echo $name?>"><?php echo $config["interaction"]["channel_msg"] ?></span>
					<form action="?clid=<?php echo $clid?>&msg" method="post">
						<label for="msg"><?php echo $config["interaction"]["channel_msg"] ?>:</label><br />
						<input type="text" id="msg" name="msg" />
						<button style="width: 100%"><?php echo $config["interaction"]["send_btn"] ?></button>
					</form>
				</li>
			</ul>
			<script>
				$(document).ready(function()
				{
					$('.hamburger').click(function()
					{
						$(this).toggleClass('is-active');
						$('.drop').slideToggle(100);
					});
					$('.form-drop').click(function()
					{
						$(this).parent().find('form').slideToggle(100);
					});
				});
			</script>
		</div>
	<?php
		}
	?>
<?php
	}
	else
	{
		echo '<script>window.close();</script>';
	}
?>
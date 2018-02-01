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
	
	
	
	if(isset($_GET['cid']))
	{
		$cid = $_GET['cid'];
		$name = "Unknown";
		
		try
		{

			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]."&nickname=".$user['username']."_web");
	
			$client = $ts3_VirtualServer->clientGetById($cid);
			
			
			if(isset($_GET['kick']))
			{

				$msg = $_POST['reason'];
				
				$kickType = $_GET['kick'];
				
				if($kickType == "server")
				{
					//log
					$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
					$result = $statement->execute(array('uname' => $user['username'], 's' => 'WARNING', 'msg' => 'Kicked client: '.$client->__toString().' for reason: '.$msg.' from server!', 'ts' => date(DATE_ATOM)));
					$client->kick(TeamSpeak3::KICK_SERVER, $msg);
				}
				else
				{
					//log
					$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
					$result = $statement->execute(array('uname' => $user['username'], 's' => 'WARNING', 'msg' => 'Kicked client: '.$client->__toString().' for reason: '.$msg.' from channel!', 'ts' => date(DATE_ATOM)));
					$client->kick(TeamSpeak3::KICK_CHANNEL, $msg);
				}

				echo '<script>window.close();</script>';
			}
			
			if(isset($_GET['ban']))
			{
				$msg = $_POST['reason'];
				
				$time = $_POST['duration'];
				
				$kickType = $_GET['ban'];
				
				try
				{	
					//log
					$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
					$result = $statement->execute(array('uname' => $user['username'], 's' => 'WARNING', 'msg' => 'Banned client: '.$client->__toString().' for reason: '.$msg.' from server for '.$time.' seconds!', 'ts' => date(DATE_ATOM)));				
					$client->ban(intval($time), $msg);
				}
				catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
				{
					die('<h1>'.$config["error"]["invalid_ban"].'</h1>'.$e);
					//log
					$statement = $pdo->prepare("INSERT INTO log (username, state, msg, timestamp) VALUES (:uname, :s, :msg, :ts)");
					$result = $statement->execute(array('uname' => $user['username'], 's' => 'ERROR', 'msg' => 'Tried to ban client: '.$client->__toString().' for reason: '.$msg.' from server! Failed by error: '.$e, 'ts' => date(DATE_ATOM)));
				}
				
				echo '<script>window.close();</script>';
			}
			
			$name = $client->__toString();
		}
		catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
		{
			echo $e;
			die('<h1>'.$config["error"]["invalid_id"].'</h1>');
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
	<h1><?php echo $config["general"]["client_topic"].$name?></h1>
	<table>
		<tr>
			<td><?php echo $config["general"]["client_desc"] ?></td>
			<td><?php echo $client['client_description']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_muted"] ?></td>
			<td><?php if($client['client_input_muted'] == 0){echo $config["general"]["client_muted_no"];}else{echo $config["general"]["client_muted_yes"];}?></td>
		<tr>
			<td><?php echo $config["general"]["client_version"]?></td>
			<td><?php echo $client['client_version']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_country"]?></td>
			<td><?php echo $client['client_country']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_platform"]?></td>
			<td><?php echo $client['client_platform']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_last_login"]?></td>
			<td><?php echo date("d.m.Y\ H:i:s\ ", $client['client_lastconnected'])?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_talk_power"]?></td>
			<td><?php echo $client['client_talk_power']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_global_id"]?></td>
			<td><?php echo $client['client_unique_identifier']?></td>
		</tr>
		<tr>
			<td><?php echo $config["general"]["client_server_grps"]?></td>
			<td>
				<div class="servergroups">
					<table>
						<tbody>
						<?php
							try
							{
								foreach($client->memberOf() as $group)
								{
									if(($group->__toString() != "Guest Server Query") && ($group->__toString() != "Admin Server Query") && ($group->__toString() != "Server Admin") && ($group->__toString() != "Normal") && ($group->__toString() != "Guest"))
									{
										echo '<tr>';

										echo '<td style="font-weight: initial">'.$group->__toString().'</td>';
										echo '<td>'.getImage($group).'</td>';
										echo '</tr>';
									}
								}
							}
							catch(Exception $e)
							{
								echo '<tr><td>'.$config["error"]["client_grps_load"].'</td></tr>';
							}
						?>
						</tbody>
					</table>
				</div>
			</td>
		</tr>
	</table>
	<br />
	<?php
		if($power >= 1)
		{
		?>
		<div class="admin noselect">
			<h1><?php echo $config["general"]["action"]?></h1>
			<ul>
				<li><button style="float: right;" class="hamburger hamburger--collapse" type="button" id="dropbtn"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
				<?php
				if($power >= 2)
				{
				?>
				<li class="drop">
					<div class="form-contain">
						<span class="form-drop" title="<?php echo $config["interaction"]["client_kick"].' '.$client['client_nickname']?>"><?php echo $config["interaction"]["client_kick"]?></span>
						<form action="?cid=<?php echo $cid?>&kick" method="post">
							<label for="reason"><?php echo $config["interaction"]["reason"]?></label><br />
							<input type="text" id="reason" name="reason" />
							<button onclick="this.form.action += '=server'" class="submit"><?php echo $config["interaction"]["client_kick"].' '.$config["interaction"]["kick_server"]?></button>
							<button onclick="this.form.action += '=channel'" style="float: right;" class="submit"><?php echo $config["interaction"]["client_kick"].' '.$config["interaction"]["kick_channel"]?></button>
						</form>
					</div>
				</li>
				<li class="drop">
					<div class="form-contain">
						<span class="form-drop" title="<?php echo $config["interaction"]["client_ban"].' '.$client['client_nickname']?>"><?php echo $config["interaction"]["client_ban"]?></span>
						<form action="?cid=<?php echo $cid?>&ban=true" method="post">
							<label for="reason"><?php echo $config["interaction"]["reason"]?></label><br />
							<input type="text" id="reason" name="reason" />
							<label for="reason"><?php echo $config["interaction"]["ban_duration"]?></label><br />
							<input type="number" id="duration" name="duration" value="1"/>s<button type="button" onclick="$('#duration').val(-1)" id="duration-btn"><?php echo $config["interaction"]["ban_perm"]?></button>
							<button type="submit" class="full submit"><?php echo $config["interaction"]["client_ban"]?></button>
						</form>
					</div>
				</li>
				<?php
				}
				?>
				<li class="drop"><span class="action-btn" id="poke" title="<?php echo $config["interaction"]["client_poke"].' '.$client['client_nickname']?>"><?php echo$config["interaction"]["client_poke"]?></span></li>
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
					$('.action-btn').click(function()
					{
						var id = $(this).attr('id');
						var cid = "<?php echo $cid?>";
						var text = prompt("<?php echo $config["interaction"]["enter_msg"]?>");
						var uid = "<?php echo $user['uniqueID']?>";
						var notifyType = "alert";
						
						if(id == "message")
						{
							if("Notification" in window)
							{
								if(Notification.permission === "granted")
								{
									notifyType = "note";
								}
								else if(Notification.permission !== "denied")
								{
									Notification.requestPermission(function(permission)
									{
										if(permission === "granted")
										{
											notifyType = "note";
										}
									});
								}
							}
						}
						
						if(text != null)
						{
							$.ajax(
							{
								url: 'script/ajax_client.php',
								type: 'post',
								dataType: "json",
								data: {'action': id, 'cid': cid, 'text': text, 'uid': uid},
								success: function(content)
								{
									var status = content['status'];
									if(content['action'] == "poke")
									{
										if(status == "success")
										{
											console.log(status);
										}
										else 
										{
											console.log(status);
											console.log(content['error']);
										}
									}
									else
									{
										if(status == "error")
										{
											console.log('Error recieved at: ' + getCurrentTime());
											console.log(content['error']);
										}
										else
										{
											if(notifyType == "alert")
											{
												alert(content['username'] + ": " + content['message']);
											}
											else if(notifyType == "note")
											{
												var n = createNotification('Message recieved', 'images\\shortcut.png', content['username'] + ': ' + content['message']);
												setTimeout(n.close.bind(n), 5000);
												console.log('Message recieve status: ' + status);
												console.log(content['username'] + " : " + content['message'] + " (" + getCurrentTime() + ")");
											}
											else 
											{
												console.log(notifyType);
												console.log('Message recieve status: ' + status);
												console.log(content['username'] + " : " + content['message'] + " (" + getCurrentTime() + ")");
											}
										}
									}
								},
								error: function(xhr, desc, err)
								{
									console.log(xhr),
									console.log("Details: " + desc + "\nError:" + err);
								}
							});
						}
					});

					function createNotification(theTitle, theIcon, theBody)
					{
						var options = 
						{
							body: theBody,
							icon: theIcon
						}
						return new Notification(theTitle, options);
					}

					function getCurrentTime()
					{
						var currDate = new Date();
						var hours = currDate.getHours();
						var minutes = currDate.getMinutes();
						var seconds = currDate.getSeconds();
						
						return hours + ':' + minutes + ':' + seconds;
					}
				});
			</script>
		</div>
		<?php
		}
		else
		{
			echo "Fail";
		}
	?>
</div>
<?php
	}
?>
		
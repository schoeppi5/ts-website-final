<?php
	include("header.php");
	include("include/nav.php");
?>
		<div class="container">
			<div class="col col-left">
				<div class="ts-con">
					<h3 id="ts-name"></h3>
					<ul class="ts-info-row">
						<li>
							<div class="ts-col-left"><?php echo $config["general"]["ts_address"] ?>:</div>
							<div class="ts-col-right" id="ts-address"></div>
						</li>
						<li>
							<div class="ts-col-left"><?php echo $config["general"]["ts_users_online"] ?>:</div>
							<div class="ts-col-right" id="ts-users"></div>
						</li>
						<li>
							<div class="ts-col-left"><?php echo $config["general"]["ts_country"] ?>:</div>
							<div class="ts-col-right" id="ts-country"></div>
						</li>
						<li>
							<a href="teamspeak.php" title="View TeamSpeak-Server" class="ts-look" ><?php echo $config["interaction"]["ts_btn"] ?></a>
						</li>
					</ul>
				</div>
			</div>
			<script>
				var embed = true;
				var server_ip;
				var server_port;
				$.getJSON('config/ts_server_config.json', function(json)
				{
					embed = json.embed;
					server_ip = json.server.address;
					server_port = json.server.port;
				});
				$('document').ready(function(){
					$.getJSON('https://api.planetteamspeak.com/serverstatus/' + server_ip + ':' 
						+ server_port + '/', function(json)
					{
						if(json.status == 'success')
						{						
							if(json.result.online)
							{
								$('#ts-name').css("color", "#2dfc16");
								$('#ts-name').html('<a href="ts3server://' + server_ip + '?port=' 
									+ server_port + '" title="Join ' + json.result.name 
									+ '" id="ts-name-link">'
									+ json.result.name + '</a>');
								if(json.result.password){$('#ts-name').append(' &#x1f512;');}
							}
							else
							{
								$('#ts-name').css("color", "#ed2d2d");
								$('#ts-name').html(json.result.name);
							}
							
							$('#ts-address').html(json.result.address);
							
							$('#ts-users').html(json.result.users + '/' + json.result.slots);
							
							$('#ts-country').html('<img src="./lib/ts3phpframework/images/flags/' + json.result.country.toLowerCase() + '.png" title="' + json.result.country + '" />');
						}
						else
						{
							$('#ts-name').css("color", "#ed2d2d");
							$('#ts-name').html("<?php echo $config["error"]["ts_not_found"] ?>");
						}
					});
					$('#ts-name').mouseenter(function(){
						$(this).find("a").addClass("animated tada");
					})
					.mouseleave(function(){
						$(this).find("a").removeClass("animated tada");
					});
				});
			</script>
			<div class="col col-middle">
			<?php
				if($config["mc"]["show"])
				{
					?>
				<div class="server-view" id="mc">
				</div>
				<?php
				}
				if($config["gm"]["show"])
				{
				?>
				<div class="server-view" id="gm">
					<script>
						function reloadGM(init = false)
						{
							if(init)
							{
								$.ajax(
									{
										url: './include/gm.php',
										type: "post",
										dataType: "html",
										data: {"init": true},
										success: function(content)
										{
											var pos1 = content.indexOf('<span id="get">');
											content = content.slice(pos1 + 15);
											if(content)
											{
												$('#gm').html(content);
											}
											else
											{
												console.log("Fail");
											}
										}
									});
							}
							else
							{
								if($('#gm-info').is(":visible"))
								{
									$.ajax(
									{
										url: './include/gm.php',
										type: "post",
										dataType: "html",
										data: {"extend": true},
										success: function(content)
										{
											var pos1 = content.indexOf('<span id="get">');
											content = content.slice(pos1 + 15);
											if(content)
											{
												$('#gm').html(content);
											}
											else
											{
												console.log("Fail");
											}
										}
									});
								}
								else
								{
									$.ajax(
									{
										url: './include/gm.php',
										type: "post",
										dataType: "html",
										data: {},
										success: function(content)
										{
											var pos1 = content.indexOf('<span id="get">');
											content = content.slice(pos1 + 15);
											if(content)
											{
												$('#gm').html(content);
											}
											else
											{
												console.log("Fail");
											}
										}
									});
								}
							}
						}
						function reloadMC(init = false)
						{
							if(init)
							{
								$.ajax(
									{
										url: './include/mc.php',
										type: "post",
										dataType: "html",
										data: {"init": true},
										success: function(content)
										{
											var pos1 = content.indexOf('<span id="get">');
											content = content.slice(pos1 + 15);
											if(content)
											{
												$('#mc').html(content);
											}
											else
											{
												console.log("Fail");
											}
										}
									});
							}
							else
							{
								if($('#mc-info').is(":visible"))
								{
									$.ajax(
									{
										url: './include/mc.php',
										type: "post",
										dataType: "html",
										data: {"extend": true},
										success: function(content)
										{
											var pos1 = content.indexOf('<span id="get">');
											content = content.slice(pos1 + 15);
											if(content)
											{
												$('#mc').html(content);
											}
											else
											{
												console.log("Fail");
											}
										}
									});
								}
								else
								{
									$.ajax(
									{
										url: './include/mc.php',
										type: "post",
										dataType: "html",
										data: {},
										success: function(content)
										{
											var pos1 = content.indexOf('<span id="get">');
											content = content.slice(pos1 + 15);
											if(content)
											{
												$('#mc').html(content);
											}
											else
											{
												console.log("Fail");
											}
										}
									});
								}
							}
						}
						reloadMC(true);
						reloadGM(true);
						setInterval(function(){reloadMC()}, 10000);
						setInterval(function(){reloadGM()}, 10000);
					</script>
				</div>
				<?php
				}
				?>
			</div>
			<div class="col col-right">
				<?php			
					function fetchClients($power)
					{
						global $config, $pdo, $user;
						
						$statement = $pdo->prepare("SELECT * FROM user WHERE power = :p");
						$result = $statement->execute(array('p' => $power));
						while($userShow = $statement->fetch())
						{
							if(isset($_SESSION["userID"]))
							{
								if(!($userShow["username"] == $user['username']))
								{
									try
									{
										$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
										$id = $ts3_VirtualServer->clientGetByUid($userShow["cuid"])['clid'];
										$online = '<span class="user-right" style="color: #2dfc16">online</span>';
									}
									catch(Exception $e)
									{
										$id = "";
										$online = '<span class="user-right" style="color: #ed2d2d">offline</span>';
									}
									echo '<div class="user" cid="'.$userShow["username"].'"><span class="user-left">'.$userShow["username"].'</span>'.$online.'</div>';
								}
							}
							else
							{
								echo '<div class="user"><span>'.$userShow["username"].'</span></div>';
							}
						}
					}
					
					fetchClients(3);
					fetchClients(2);
					fetchClients(1);
				?>
			</div>
			<script>
				$(document).ready(function()
				{
					$(window).resize(function()
					{
					});
					
					$('.user').click(function()
					{
						id = $(this).attr('cid');
						window.open("chat.php?name=" + id, '_blank');
					});
					$('.server-view').click(function()
					{
						id = $(this).attr("id") + "-info";
						$('#' + id).slideToggle(200);
					});
				});
			</script>
		</div>
<?php
	include("include/footer.php");
?>
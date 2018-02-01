<?php
	require_once("../lib/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
	require_once("../config/config.php");
	
	if(isset($_GET['lang']) && !empty($_GET['lang']))
	{
		error_reporting(0);
		if(!include("../lang/".$_GET['lang'].".php"))
		{
			include("../lang/en.php");
			$_SESSION["lang"] = "en";
			setcookie("lang", $_SESSION["lang"], time() + (365 * 24 * 60 * 60));
		}
		else
		{
			$_SESSION["lang"] = $_GET["lang"];
			setcookie("lang", $_SESSION["lang"], time() + (365 * 24 * 60 * 60));
			error_reporting(-1);
		}
	}
	elseif(isset($_SESSION["lang"]) && !empty($_SESSION['lang']))
	{
		include("../lang/".$_SESSION['lang'].".php");
	}
	elseif(isset($_COOKIE["lang"]) && !empty($_COOKIE["lang"]))
	{
		include("../lang/".$_COOKIE['lang'].".php");
		$_SESSION["lang"] = $_COOKIE["lang"];
	}
	else
	{
		include("../lang/en.php");
		$_SESSION["lang"] = "en";
		setcookie("lang", $_SESSION["lang"], time() + (365 * 24 * 60 * 60));
	}
	
?>
<script>
	function timeout()
	{
		var time = 11;
		var timeout_reload = setInterval(function()
		{
			time--;
			$('#timeout').html('<?php echo $config["error"]["ts_try_again"] ?> ' + time);
			if(time < 0)
			{
				clearInterval(timeout_reload);
				$('#timeout').html('Trying again...');
				reload();
			}
		}, 1000);
	}
</script>
<?php
	
	try
	{		
		$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
		echo $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("lib/ts3phpframework/images/viewer/", "lib/ts3phpframework/images/flags/", "data:image"));
	}
	catch(TeamSpeak3_Transport_Exception $e)
	{
		echo $config["error"]["ts_timeout"].'<p id="timeout">'.$config["error"]["ts_try_again"].'</p><script>timeout();</script>';
	}
	catch(TeamSpeak3_Adapter_Exception $e)
	{
		try
		{
			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"].'#use_offline_as_virtual');
			
			if(!$ts3_VirtualServer->isOnline())
			{
				echo $config["error"]["ts_restart"];
				$ts3_VirtualServer->start();
				echo '<script>reload();</script>';
			}
			else
			{
				echo $config["error"]["ts_invalid"].'<button onclick="reload()">'.$config["error"]["ts_reload_btn"].'</button>';
			}
		}
		catch(Exception $e)
		{
			echo $config["error"]["ts_invalid"].'<button onclick="reload()">'.$config["error"]["ts_reload_btn"].'</button>';
		}
	}
	catch(Exception $e)
	{
		echo $config["error"]["ts_invalid"].'<button onclick="reload()">'.$config["error"]["ts_reload_btn"].'</button>';
	}
?>
<script>
	$(document).ready(function()
	{
		$('.ts3_viewer.client').click(function()
		{
			var cid = $(this).attr("summary");
			window.open("client.php?cid=" + cid, '_blank');
		});
		
		$('.ts3_viewer.channel').click(function()
		{
			var clid = $(this).attr("summary");
			window.open('channel.php?clid=' + clid, '_blank');
		});
		
		$('.ts3_viewer.server').click(function()
		{
			var sid = $(this).attr('summary');
			window.open('server.php?sid=' + sid, '_blank');
		});
	});
</script>
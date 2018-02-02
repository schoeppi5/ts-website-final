<?php
	include("../header.php");
	
	require __DIR__ . '/../lib/source/steam-condenser/steam-condenser.php';
	
	error_reporting(E_ERROR);
?>
<span id="get">
<?php
	
	$result = '';
	
	try
	{
		if(isset($_POST['init']))
		{
			$server = new SourceServer($config["gm"]["host"], $config["gm"]["port"], 1000);
		}
		else
		{
			$server = new SourceServer($config["gm"]["host"], $config["gm"]["port"], 6000);
		}
		$server->initialize();
		$info = $server->getServerInfo();
		
		$result .= '<span class="server-name col-left">'.$info['serverName'].' <br />('.$config["general"]["gameserver_version"].' '.$info['gameVersion'].')</span><span class="server-players col-middle">
		<img width="64" height="64" alt="favicon" src="http://combineoverwiki.net/images/c/c7/Gmodlogo.svg" /><br />'.$config["general"]["gameserver_players"].' '.$info['numberOfPlayers'].'/'
		.$info['maxPlayers'].'</span><span class="server-address col-right" style="color: #2dfc16"><a href="steam://connect/'.$config["gm"]["host"].':'.$info['serverPort'].'">'.$config["gm"]["host"].':'.$info['serverPort'].'</a><br />(Ping: '.$server->updatePing().')</span>';
	}
	catch(Exception $e)
	{
		if(isset($_POST['init']))
		{
			$result .= '<span class="server-offline" style="color: #ed2d2d">'.$config["error"]["server_gm_offline"].'</span>';
		}
		else
		{
			exit(1);
		}
	}
	
	if(isset($_POST['extend']))
	{
		$result .= '<div class="server-info" id="gm-info">';
	}
	else
	{
		$result .= '<div class="server-info" id="gm-info" style="display: none">';
	}
	$result .= '<hr />';
	$result .= '<div class="server-player-info">';
	
	try
	{
		$players = $server->getPlayers($config["gm"]["rconPassword"]);
	}
	catch(Exception $e)
	{
		$players = "";
	}
	
	if(!empty($players))
	{
		$result .= '<table><tr><th>'.$config["general"]["gm_player_name_top"].'</th><th>'.$config["general"]["gm_player_scre_top"].'</th><th>'.$config["general"]["gm_player_ip_top"].'</th><th>'.$config["general"]["gm_player_ping_top"].'</th></tr>';
		foreach($players as $player)
		{
			$playerName = $config["general"]["gm_player_name_def"];
			$playerScore = $config["general"]["gm_player_scre_def"];
			$playerIP = $config["general"]["gm_player_ip_def"];
			$playerPing = $config["general"]["gm_player_ping_def"];
			
			if($player->getName() != "")
			{
				$playerName = $player->getName();
				$playerScore = $player->getScore();
				$playerIP = $player->getIpAddress();
				$playerPing = $player->getPing();
			}
			$result .= '<tr><td>'.$playerName.'</td><td>'.$playerScore.'</td><td>'.$playerIP.'</td><td>'.$playerPing.'</td></tr>';
		}
		$result .= '</table>';
	}
	else
	{
		$result .= '<span class="server-no-players">'.$config["error"]["server_no_players"].'</span>';
	}
	
	$result .= '</div>';
	$result .= '<div class="server-player-info">';
	
	$vac = $config["general"]["gm_vac_no"];
	if($info['secureServer'] == 1)
	{
		$vac = $config["general"]["gm_vac_yes"];
	}
	
	$result .= '<span class="server-info-item">'.$config["general"]["gm_map"].' '.$info['mapName'].'</span><br />
	<span class="server-info-item">'.$config["general"]["gm_mode"].' '.$info['gameDesc'].'</span><br />
	<span class="server-info-item">'.$config["general"]["gm_vac"].' '.$vac.'</span>';
	
	$result .= '</div></div>';
	
	echo $result;
?>
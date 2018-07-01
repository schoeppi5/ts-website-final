<?php
	include("../header.php");

	require __DIR__ . '/../lib/source/MinecraftQuery.php';
	require __DIR__ . '/../lib/source/MinecraftQueryException.php';
	require __DIR__ . '/../lib/source/MinecraftPing.php';
	require __DIR__ . '/../lib/source/MinecraftPingException.php';
	
	use xPaw\MinecraftQuery;
	use xPaw\MinecraftQueryException;
	use xPaw\MinecraftPing;
	use xPaw\MinecraftPingException;
?>
<span id="get">
<?php
	
	$response = "";
	
	try
	{
		$Query = new MinecraftQuery();							
		$Ping = new MinecraftPing($config['mc']['host'], $config['mc']['port']);
		if(isset($_POST['init']))
		{
			$Query->Connect( $config['mc']['host'], $config['mc']['queryPort'], 3);
		}
		else
		{
			$Query->Connect( $config['mc']['host'], $config['mc']['queryPort'], 8);
		}
		$result = $Ping->Query();
		
		$info = $Query->GetInfo();
		$players = $Query->GetPlayers();
		
		$response .= '<span class="server-name col-left">'.ucfirst(strtolower($info['GameName'])).' <br />('.$config["general"]["gameserver_version"].' '.$info['Version'].')</span><span class="server-players col-middle">
		<img width="64" height="64" alt="favicon" src="'.$result['favicon'].'" /><br />'.$config["general"]["gameserver_players"].' '.$info['Players'].'/'
		.$info['MaxPlayers'].'</span><span class="server-address col-right" style="color: #2dfc16">'.$info['HostIp'].':'.$info['HostPort'].'</span>';
	}
	catch(Exception $e)
	{
		if(isset($_POST['init']))
		{
			$response .= '<span class="server-offline" style="color: #ed2d2d">'.$config["error"]["server_mc_offline"].'</span>';
		}
		else
		{
			exit();
		}
	}
	
	if(isset($_POST['extend']))
	{
		$response .= '<div class="server-info" id="mc-info">';
	}
	else
	{
		$response .= '<div class="server-info" id="mc-info" style="display: none">';
	}
	$response .= '<hr />';
	$response .= '<div class="server-player-info">';
	if(!empty($players))
	{
		$response .= '<table><tr><th>'.$config["general"]["mc_player_name_top"].'</th></tr>';
		foreach($players as $player)
		{
			$response .= '<tr><td style="text-align: center; border-right: none">'.$player.'</td></tr>';
		}
		$response .= '</table>';
	}
	else
	{
		$response .= '<span class="server-no-players">'.$config["error"]["server_no_players"].'</span>';
	}
	$response .= '</div>';
	
	if($config["mc"]["displayMods"])
	{
		$response .= '<div class="server-mods">';
			if(!empty($result['modinfo']))
			{
				$response .= '<table><tr><th>'.$config["general"]["mc_mod_name_top"].'</th><th>'.$config["general"]["mc_mod_version_top"].'</th></tr>';
				foreach($result['modinfo']['modList'] as $mod)
				{
					$response .= '<tr><td>'.$mod['modid'].'</td><td>'.$mod['version'].'</td></tr>';
				}
				$response .= '</table>';
			}
			else
			{
				$response .= '<span class="server-no-mods">'.$config["error"]["mc_no_mods"].'</span>';
			}
		$response .= '</div>';
	}
	$response .= '</div>';
	
	echo $response;
?>
<?php
function getImageTag($name, $text = "", $class = null, $iconpath = TRUE, $flagpath = FALSE)
	{
		$src = "";

		if($iconpath)
		{
			//$src = $this->iconpath;
		}

		if($flagpath)
		{
			//$src = $this->flagpath;

		}

		return "<img src='" . $src . $name . "' title='" . $text . "' alt='' align='top' />";
	}

	
	function getImage($group)
	{
		$html = "";
		$viewer = new TeamSpeak3_Viewer_Html("lib/ts3phpframework/images/viewericons/", "lib/ts3phpframework/images/countryflags/", "data:image");
		$ftClient = "data:image";
		
		if(!$group["iconid"]) return;

		$type = ($group instanceof TeamSpeak3_Node_Servergroup) ? "Server Group" : "Channel Group";
		
		try
		{		
			if(!$group->iconIsLocal("iconid") && $ftClient)
			{
				$download = $group->getParent()->transferInitDownload(rand(0x0000, 0xFFFF), 0, $group->iconGetName("iconid"));
					
				if($ftClient == "data:image")
				{
					$download = TeamSpeak3::factory("filetransfer://" . (strstr($download["host"], ":") !== FALSE ? "[" . $download["host"] . "]" : $download["host"]) . ":" . $download["port"])->download($download["ftkey"], $download["size"]);
				}
				
				if($ftClient == "data:image")
				{
					$html .= getImageTag("data:" . TeamSpeak3_Helper_Convert::imageMimeType($download) . ";base64," . base64_encode($download), $group . " [" . $type . "]", null, FALSE);
				}
				else
				{
					$html .= getImageTag($ftClient . "?ftdata=" . base64_encode(serialize($download)), $group . " [" . $type . "]", null, FALSE);
				}
			}
		}
		catch(TeamSpeak3_Transport_Exception $e)
		{
			die('<h1>Error occurred: Timeout!</h1>');
		}
		return $html;
	}
	
	function isMember($group, $client)
	{
		foreach($group->clientList() as $regClient)
		{
			echo "Going throw clientlist";
			if($regClient['client_unique_identifier'] == $client['client_unique_identifier'])
			{
				return true;
			}
		}
		return false;
	}
	
	function getImageChannel($channel)
	{
		$viewer = new TeamSpeak3_Viewer_Html("lib/ts3phpframework/images/viewericons/", "lib/ts3phpframework/images/countryflags/", "data:image");
		$ftClient = "data:image";
		
		if($channel instanceof TeamSpeak3_Node_Channel && $channel->isSpacer()) return;

		$html = "";

		if($channel["channel_icon_id"])
		{
			if(!$channel->iconIsLocal("channel_icon_id") && $ftClient)
			{
				$download = $channel->getParent()->transferInitDownload(rand(0x0000, 0xFFFF), 0, $channel->iconGetName("channel_icon_id"));

				if($ftClient == "data:image")
				{
					$download = TeamSpeak3::factory("filetransfer://" . (strstr($download["host"], ":") !== FALSE ? "[" . $download["host"] . "]" : $download["host"]) . ":" . $download["port"])->download($download["ftkey"], $download["size"]);
				}

				if($ftClient == "data:image")
				{
					$html .= getImageTag("data:" . TeamSpeak3_Helper_Convert::imageMimeType($download) . ";base64," . base64_encode($download), "Channel Icon", null, FALSE);
				}
				else
				{
					$html .= getImageTag($ftClient . "?ftdata=" . base64_encode(serialize($download)), "Channel Icon", null, FALSE);
				}
			}
		}

		return $html;
	}
?>
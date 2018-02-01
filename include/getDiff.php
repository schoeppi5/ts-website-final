<?php
	include("../header.php");
	include("../lib/custom/custom.php");

	$server = TeamSpeak3::factory("serverquery://".$config["ts"]["username"].":".$config["ts"]["password"]."@".$config["ts"]["host"].":".$config["ts"]["queryport"]."/?server_port=".$config["ts"]["port"]);
	
	$d1 = new DateTime();
	$d2 = new DateTime('@'.(time() - $server['virtualserver_uptime']));
	$interval = $d2->diff($d1);
	echo $interval->format('%Y years %M months %D days %H hours %I minutes %S seconds');
?>
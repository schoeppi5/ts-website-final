<?php
	include("../config/login_config.php");
	
	$statement = $pdo->prepare("SELECT * FROM log");
	$result = $statement->execute();
	
	$response  = '<tr>';
	$response .= '<th>Username</th>';
	$response .= '<th>Flag</th>';
	$response .= '<th>Message</th>';
	$response .= '<th>Timestamp</th>';
	$response .= '</tr>';
	
	$count = 0;
	
	while(($log = $statement->fetch()))
	{
		if(strcmp($log['state'], "WARNING") == 0)
		{
			$response .= '<tr class="fetched-row" style="background-color: #faff00">';
			$response .= "<td class='username'>".$log['username']."</td>";
			$response .= "<td class='flag'>".$log['state']."</td>";
			$response .= "<td class='msg'>".$log['msg']."</td>";
			$response .= "<td class='time'>".$log['timestamp']."</td>";
			$response .= '<tr>';
			$response .= '<br />';
			$count++;
		}
		else
		{
			$response .= '<tr class="fetched-row">';
			$response .= "<td class='username'>".$log['username']."</td>";
			$response .= "<td class='flag'>".$log['state']."</td>";
			$response .= "<td class='msg'>".$log['msg']."</td>";
			$response .= "<td class='time'>".$log['timestamp']."</td>";
			$response .= '<tr>';
			$response .= '<br />';
			$count++;
		}
	}
	
	if($count > 0)
	{
		echo $response;
	}
	else
	{
		echo '<tr><td>No log entries!</td></tr>';
	}
?>
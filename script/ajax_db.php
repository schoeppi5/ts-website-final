<?php
	include("../config/login_config.php");
	$cmd = $_POST['cmd'];

	if($cmd == "delete")
	{
		$times = $_POST['ts'];
		$statement = $pdo->prepare("DELETE FROM log WHERE timestamp = :ts");
		$result = $statement->execute(array('ts' => $times));
		if($result)
		{
			echo "success";
		}
		else
		{
			echo ($result) ? 'true' : 'false';
			echo json_encode($statement->errorInfo());
		}
	}
	elseif($cmd == "deleteAll")
	{
		$statement = $pdo->prepare("DELETE FROM log");
		$result = $statement->execute();
		if($result)
		{
			echo "success";
		}
		else
		{
			echo ($result) ? 'true' : 'false';
			echo json_encode($statement->errorInfo());
		}
	}
?>
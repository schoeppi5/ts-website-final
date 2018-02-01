
<?php
	include("header.php");
	include("include/nav.php");
	
	if(!isset($_SESSION['userID']))
	{
		die('<h1>'.$config["error"]["log_in_to_view"].'</h1>');
	}
	
	$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uname");
	$result = $statement->execute(array('uname' => $_SESSION['userID']));
	$user = $statement->fetch();
	
	if(!$user)
	{
		die('<h1>'.$config["error"]["log_in_to_view"].'</h1>');
	}
?>
<link rel="stylesheet" href="style/viewer.css" type="text/css" />
	
	<div class="viewer-container">
		<p class="reload"></p>	
		<div class="viewer-load">
		</div>
	</div>
	<div class="load-cover"></div>
<script type="text/javascript" src="script/viewer.js"></script>


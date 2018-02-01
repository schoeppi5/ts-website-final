<?php
	include("config/config.php");
	include("config/login_config.php");
	require_once("lib/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
	if(isset($_GET['lang']) && !empty($_GET['lang']))
	{
		error_reporting(0);
		if(!include("lang/".$_GET['lang'].".php"))
		{
			include("lang/en.php");
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
		include("lang/".$_SESSION['lang'].".php");
	}
	elseif(isset($_COOKIE["lang"]) && !empty($_COOKIE["lang"]))
	{
		include("lang/".$_COOKIE['lang'].".php");
		$_SESSION["lang"] = $_COOKIE["lang"];
	}
	else
	{
		include("lang/en.php");
		$_SESSION["lang"] = "en";
		setcookie("lang", $_SESSION["lang"], time() + (365 * 24 * 60 * 60));
	}
?>
<!DOCTYPE html5>
<html>
	<head>
		<!--Meta-Tags-->
		<meta name="author" content="Philipp Schöppner" />
		<meta charset="UTF-8" />
		<meta name="description" content="Gaming" />
		<meta name="keywords" content="TeamSpeak,Minecraft,Garrys Mod,Ark Survival Evolved" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!--Shortcut Icon-->
		<link rel="shortcut icon" href="images\shortcut.png" />
		<!--Stylesheets-->
			
		<!--Own Styleheets-->
		<link rel="stylesheet" href="style/header.css" type="text/css" />
		<link rel="stylesheet" href="style/index.css" type="text/css" />
		<link rel="stylesheet" href="style/footer.css" type="text/css" />
		<link rel="stylesheet" href="style/register.css" type="text/css" />
		<link rel="stylesheet" href="style/chat.css" type="text/css" />
		<link rel="stylesheet" href="style/news.css" type="text/css" />
		
		<!--Animate.css by Daniel Eden-->
		<link rel="stylesheet" href="style/animate.css" type="text/css" />
		
		<!--Hamburger.css by Jonathan Suh-->
		<link rel="stylesheet" href="style/hamburgers.css" type="text/css" />
		
		<!--Google Fonts-->
		<link href="https://fonts.googleapis.com/css?family=Monda|Saira+Extra+Condensed|Oswald|Roboto+Mono" rel="stylesheet">
		
		<!--JQuery lib from Google-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<!--Title from config file-->
		<title><?php echo $config["general"]["title"]?></title>
	</head>
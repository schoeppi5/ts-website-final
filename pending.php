<?php
	include("header.php");
	include("include/nav.php");
	
	if(isset($_GET['key']))
	{
		$statement = $pdo->prepare("SELECT * FROM pending WHERE validation_key = :vk");
		$result = $statement->execute(array('vk' => $_GET['key']));
		$user = $statement->fetch();
		
		if($user)
		{
			$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
			$url .= $_SERVER['SERVER_NAME'];
			$url .= htmlspecialchars($_SERVER['REQUEST_URI']);
			$themeurl = dirname($url) . "/verify.php?key=".$_GET['key'];
			
			$mailtext = '<html>
					<head>
						<title>'.$config["email"]["title"].'</title>
					</head>
				 
					<body>
				 
						<h1>'.$config["email"]["heading"].'</h1>
					 
						<p>'.$config["email"]["text"].'</p>
					 
						<a href="'.$themeurl.'" title="'.$config["email"]["link_tip"].'">'.$themeurl.'</a>
				 
					</body>
				</html>
			';
			
			$mailtext = wordwrap($mailtext, 70);
			 
			$mailto 	= $user['email'];
			$from		= $config["email"]["from"];
			$subject    = "E-Mail bestätigen";
			 
			$header  = "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html; charset=utf-8\r\n";
			 
			$header .= "From: $from\r\n";
			// $header .= "Cc: $cc\r\n";  //in case cc wanted
			$header .= "X-Mailer: PHP ". phpversion();
			 
			mail( $mailto,
				  $subject,
				  $mailtext,
				  $header);
			
			echo '<span id="pending" >'.$config["general"]["email_success"].'</span>';
		}
		else
		{
			echo '<span id="pending-error">'.$config["error"]["key_not_found"].'</span>';
		}
	}
	else
	{
		header ("Location:index.php");
	}
?>
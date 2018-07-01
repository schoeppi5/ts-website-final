<?php
	include("script/login.php");
?>
	<body>
		<script type="text/javascript" src="script/navi_login.js"></script>
		<header>
			<!--<ul>
			</ul>-->
			<div class="title">
				<h1 class="animated zoomin"><a href="index.php"><?php echo $config["general"]["heading"]?></a></h1>
			</div>
		</header>
		<nav class="navi noselect">
			<ul>
				<li class="drop-btn"><a  href="index.php" id="mobile-link"><?php echo $config["general"]["heading"]?></a><button style="float: right;" class="hamburger hamburger--spin" type="button" id="dropbtn"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button></li>
				<!--<a onClick="dropDown()">&#9776;</a> <-- Alternative -->
				<li class="drop"><a id="home" href="index.php"><?php echo $config["general"]["home"]?></a></li>
				<li class="drop normal"><a href="rules.php"><?php echo $config["general"]["nav1"]?></a></li>
				<li class="drop normal"><a href="report.php"><?php echo $config["general"]["nav2"]?></a></li>
				<li class="right drop normal"><a id="lang-btn"><?php echo $config["general"]["lang"]?></a>
					<div class="lang-con">
						<ul>
							<li class="lang"><a href="?lang=en">English</a></li>
							<li class="lang"><a href="?lang=de">Deutsch</a></li>
						</ul>
					</div>
				</li>
				<li class="right drop" id="login-container"><a style="cursor: pointer" id="login-btn"><?php if(isset($_SESSION['userID']) && isset($user['email'])){echo $user['email'];}else {echo 'login';}?></a>
					<?php if($error == "nothing"){?><div class="login"><?php } else { ?><div class="login show"><?php } ?>
						<?php
							if(isset($_SESSION['userID']))
							{
								$statement = $pdo->prepare("SELECT * FROM user WHERE uniqueID = :uid");
								$statement->execute(array("uid" => $_SESSION['userID']));
								$user = $statement->fetch();
							}
							if(isset($_SESSION['userID']) && isset($user['email'])){
								include('include/logged.php');
							}
							else
							{
								include('include/email_form.php');
							}
						?>
					</div>
				</li>
			</ul>
		</nav>
		<div class="se-pre-con"></div>
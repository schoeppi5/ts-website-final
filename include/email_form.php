<form action="?login" method="post">
	<ul class="login_ul noselect">
		<li>
			<label for="email"><?php echo $config["general"]["email"] ?>:</label>
			<?php
				if($error != "mail") {
					echo '<input type="text" name="email" id="email" />';
				}
				else
				{
					echo '<input type="text" name="email" id="email" style="border-color: #ed1515" placeholder="'.$config["error"]["wrong_email"].'" />';
				}
			?>
		</li>
		<br />
		<li>
			<label for="pass"><?php echo $config["general"]["password"] ?>:</label>
			<?php
				if($error != "pass") {
					echo '<input type="password" name="pass" id="pass" />';
				}
				else
				{
					echo '<input type="password" name="pass" id="pass" style="border-color: #ed1515" placeholder="'.$config["error"]["wrong_password"].'" />';
				}
			?>
		</li>
		<br />
		<li>
			<span style="width: 100%; display: block; float: left"><input style="width: auto; float: left: margin-right: 10px;" type="checkbox" id="remember" name="remember" checked value=true /><?php echo $config["interaction"]["remember"] ?></span>
		</li>
		<li>
			<button><?php echo $config["interaction"]["login"] ?></button>
		</li>
	</ul>
</form>
<form action="register.php">
	<ul class="login_ul noselect" id="sign_ul">
		<li>
			<button id="sign"><?php echo $config["interaction"]["register"] ?></button>
		</li>
	</ul>
</form>
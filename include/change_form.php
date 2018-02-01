				<form action="?change" method="post">
					<ul id="reg_form">
						<li>
							<h3><?php echo $config["general"]["change_password"] ?></h3>
						<li>
							<label for="old"><?php echo $config["general"]["old_password"] ?>:</label><br />
							<?php if(!$errorold){?><input type="password" id="old" name="old" /><?php } else {?><input type="password" id="old" name="old" style="border-color: #ed1515" placeholder=<?php echo '"Wrong password" />';}?><br />
						</li>
						<br />
						<li>
							<label for="new"><?php echo $config["general"]["new_password"] ?>:</label><br />
							<?php if(!$errornew && !$errormpw){?><input type="password" name="new" id="new" /><?php } else {?><input type="password" name="new" id="new" style="border-color: #ed1515" placeholder=<?php if($errornew){echo '"Password must be at least 8 characters" />';} else {echo'"Passwords doesn&apos;t match" />';}}?><br />
						</li>
						<br />
						<li>
							<label for="passwd"><?php echo $config["general"]["password_repeat"] ?>:</label><br />
							<?php if(!$errormpw){?><input type="password" name="new2" id="new2" /><?php } else {?><input type="password" name="new2" id="new2" style="border-color: #ed1515" placeholder=<?php echo'"Passwords doesn&apos;t match" />';}?><br />
						</li>
						<br />
						<li>
							<?php if(!$errornomail){?><button><?php echo $config["interaction"]["change"] ?></button><?php } else { ?><a href="index.php" style="color: #ed1515; text-align: center;"><?php echo $config["error"]["account_deleted"] ?></a><?php } ?>
						</li>
					</ul>
				</form>
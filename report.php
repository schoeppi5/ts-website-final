<?php
	include("header.php");
	include("./include/nav.php");
?>
<div class="report">
	<form action="post" method="report.php">
		<label for="name">Name:</label><br />
		<?php
			if(isset($_SESSION['userID']))
			{
				echo '<input type="text" id="name" name="name" value="'.$user['username'].'" readonly/>';
			}
			else
			{
				echo '<input type="text" id="name" name="name" value="" placeholder="Please enter your name"/>';
			}
		?>
		<br />
		<label for="reason">Reason:</label><br />
		<select name="reson" id="reason">
			<option>Ban</option>
			<option>Misbehaviour</option>
			<option>Unreasonable Punishment</option>
			<option>Annoying User</option>
		</select>
	</form>
</div>
<?php
	include("header.php");
?>
<div class="console">
	<div class="console-window">
	</div>
	<div class="console-input">
		<label for="console_line">></label>
		<input type="text" id="console_line"/>
	</div>
	<script>
		$(document).ready(function()
		{
			writeTextToConsole("Rcon console Version 1.0! &copy; by Philipp Schöppner. Type /help to see possible commands");
		});
		
		function writeTextToConsole(text)
		{
			con = $('.console-window');
			con.append(text);
		}
	</script>
</div>
</body>
</html>
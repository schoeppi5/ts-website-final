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
	
	if(isset($_GET['name']) && !empty($_GET['name']))
	{
		$partner = $_GET['name'];
		
		$statment = $pdo->prepare("SELECT uniqueID FROM user WHERE username = :uname");
		$result = $statment->execute(array("uname" => $partner));
		$partnerEn = $statment->fetch()['uniqueID'];
		
?>
<div class="chat-center">
	<span class="chat-heading"><?php echo $config["general"]["chat_topic"].' '.$partner?></span>
	<div class="chat-text">
	</div>
	<div class="chat-controls">
		<input type="text" maxlength="<?php echo $config["interaction"]["chat_limit"]?>" id="msg" placeholder="<?php echo $config["general"]["chat_input_place"]?>" />
		<button id="submit"><?php echo $config["interaction"]["chat_submit"]?></button>
		<span id="max"><?php echo $config["interaction"]["chat_limit"].' '.$config["general"]["chat_limit_text"]?></span>
	</div>
	<script>
		$(document).ready(function()
		{
			updateChat();
			scrollDiv();
			setInterval(function(){updateChat()}, 10);
			$('#msg').on('input', function()
			{
				charLeft = $(this).attr("maxlength") - $(this).val().length;
				$('#max').html(charLeft + " <?php echo $config["general"]["chat_limit_text"]?>");
			});
			$('#msg').change(function(){
				send($(this).val());
				$(this).val("");
				$(this).trigger('input');
				updateChat();
				scrollDiv();
			});
		});
		function scrollDiv()
		{
			Div = $('.chat-text');
			Div.animate({ scrollTop: Div.prop("scrollHeight") - Div.height() }, 30);
		}
			
		function updateChat()
		{
			$.ajax(
			{
				url: "script/chat_ajax.php",
				type: "post",
				dataType: "json",
				data: {"action": "get", "user": "<?php echo $user['username'] ?>", "partner": "<?php echo $partnerEn ?>"},
				success: function(content)
				{
					messages = "";
					$.each(content, function(i, msg)
					{
						if(msg['from_user'] == "<?php echo $user['username']?>")
						{
							messages += '<div class="message own"><p class="msg-text own-text">' + msg['msg'] + '</p><span class="msg-date">' + msg['time'] + '</span></div>';
						}
						else
						{
							messages += '<div class="message"><p class="msg-text">' + msg['msg'] + '</p><span class="msg-date">' + msg['time'] + '</span></div>';
						}
					});
					Div = $('.chat-text');
					Div.html(messages);
				}
			});
		}
		
		function send(msg)
		{
			$.ajax(
			{
				url: "script/chat_ajax.php",
				type: "post",
				dataType: "json",
				data: {"action": "send", "from": "<?php echo $user['username'] ?>", "to": "<?php echo $partnerEn ?>", "msg": msg}
			});
		}
	</script>
</div>
<?php	
	}
	else
	{
		die('<h1>'.$config["error"]["chat_no_partner"].'</h1>');
	}
?>
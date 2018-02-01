	<body>
		<script>
			$(document).ready(function(){
				$('#home').hide();
				if(screen.width <= 801) {
					$('.drop').hide();
					$('.drop-btn').addClass('mobile');
				}
				else{
					$('.drop-btn').hide();
				}
				refreshSize();
			});
		</script>
		<header>
			<!--<ul>
			</ul>-->
			<div class="title">
				<h1 class="animated zoomin"><a href="index.php"><?php echo $config["general"]["heading"]?></a></h1>
			</div>
		</header>
		<nav class="navi noselect">
			<ul>
				<li class="drop-btn"><a  href="index.php" id="mobile-link"><?php echo $config["general"]["heading"]?></a><button style="float: right;" class="hamburger hamburger--spin" type="button" onclick="dropDown(this)" id="dropbtn"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button></li>
				<!--<a onClick="dropDown()">&#9776;</a> <-- Alternative -->
				<li class="drop"><a id="home" href="index.php"><?php echo $config["general"]["home"]?></a></li>
				<li class="drop"><a href="#"><?php echo $config["general"]["nav1"]?></a></li>
				<!--<li class="drop"><a href="#"><?php //echo $config["general"]["nav2"]?></a></li>-->
			</ul>
		</nav>
		<script>
			$(document).ready(function(){
				$(window).scroll(function() 
				{
					/*console.log($(window).scrollTop());*/
					if(screen.width > 801) {
						if ($(window).scrollTop() >= 270) {
							$('.navi').addClass('fixed');
							$('#home').show(200);
						} else {
							$('.navi').removeClass('fixed');
							$('#home').hide();
						}
					}
					else
					{
						if($(window).scrollTop() > 0){
							$('.navi').addClass('fixed');
						}
						else
						{
							$('.navi').removeClass('fixed');
						}
					}
				});
			});
			$('.hamburger').click(function(){
				$(this).toggleClass('is-active');
				if(!$(this).hasClass('is-active')){
					$('.drop').hide(200);
				}
				else
				{
					$('.drop').show(200);
				}
			});
			function refreshSize(){
			if(screen.width <= 801 && $('.drop-btn').hasClass('mobile') == false) {
				$('.drop').hide();
				$('.drop-btn').show();
				$('.drop-btn').addClass('mobile');		
			}
			else
			{
				if(screen.width > 801) {
					$('.drop').show();
					$('.drop-btn').hide();
				}
			}
			if(screen.width <= 801 && $(window).scrollTop() > 0){
				$('.navi').addClass('fixed');
			}
			else
			{
				$('.navi').removeClass('fixed');
			}
			if($('.hamburger').hasClass('is-active') && $('.drop:last-child').is(':hidden')){
				$('.hamburger').removeClass('is-active');
			}
		}
		</script>
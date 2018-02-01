$(window).on('load', function()
{
	$('.se-pre-con').fadeOut(500);
});
$(document).ready(function(){
	$('#home').hide();
	if(screen.width <= 801) {
		$('.drop').hide();
		$('.drop-btn').addClass('mobile');
	}
	else{
		$('.drop-btn').hide();
	}
	if(!$('.login').hasClass('show')){
		$('.login').hide();
		$('.login').removeClass('show');
	}
	refreshSize();
});
$(document).ready(function(){
	$(window).resize(function(){
		refreshSize();
	});
	$(window).on("orientationchange", function(event){
		refreshSize();
	});
	$(window).scroll(function() 
	{
		/*console.log($(window).offsetParent().offset());*/
		if(screen.width > 801) {
			if ($(window).scrollTop() >= 300) {
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
	var login = $('.login');
	$('#login-btn').click(function(){
		$('.lang').stop().slideUp(200);
		login.stop().slideToggle(200);
		if(screen.width <= 801){
			$('.normal').stop().slideToggle(200);
		}
	});
	$('#lang-btn').click(function()
	{
		login.stop().slideUp(200);
		$('.lang').stop().slideToggle(200);
	});
	$('.hamburger').click(function(){
		$(this).toggleClass('is-active');
		if(!$(this).hasClass('is-active')){
			$('.drop').hide(200);
			$('.login').hide();
		}
		else
		{
			if(!$('.login').hasClass('show')){
				$('.drop').show(200);
			}
			else
			{
				$('#login-container').show(200);
				$('.login').show(200);
				$('.login').removeClass('show');
			}
		}
	});
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
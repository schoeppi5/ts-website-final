$('.viewer-load').load("./include/viewer.php", function()
{
	var currDate = new Date();
	var hours = resizeTimeString(currDate.getHours());
	var minutes = resizeTimeString(currDate.getMinutes());
	var seconds = resizeTimeString(currDate.getSeconds());
	$('.reload').html('Last Sync: ' + hours + ':' + minutes + ':' + seconds);
	$('.load-cover').fadeOut(500);
	
	$('.corpus.server').append(" " + getClientsOnline());
	
});
$(document).ready(function()
{
	var auto_reload = setInterval(function(){reload()}, 120000);
	
	$('.reload').click(function()
	{
		reload();
	});
});

function reload()
{
	$('.reload').html('<img src="images/reload.gif" />');
	$('.viewer-load').load("./include/viewer.php", function()
	{
		var currDate = new Date();
		var hours = resizeTimeString(currDate.getHours());
		var minutes = resizeTimeString(currDate.getMinutes());
		var seconds = resizeTimeString(currDate.getSeconds());
		$('.reload').html('Last Sync: ' + hours + ':' + minutes + ':' + seconds);
		$('.corpus.server').append(" " + getClientsOnline());
	});
}

function resizeTimeString(param)
{
	var timeString = parseInt(param);
	if(timeString.toString().length == 1)
	{
		timeString = "0" + timeString;
	}
	
	return timeString;
}

function getClientsOnline()
{
	var clients = $('.corpus.server').attr('title');
	var searchString = "Clients: "
	var pos = clients.indexOf(searchString);
	var pos2 = clients.indexOf("|", pos);
	clients = clients.slice(pos + searchString.length, pos2);
	return clients;
}
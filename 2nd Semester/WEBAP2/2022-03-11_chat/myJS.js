$(start);

function start(){
	$("#sendMsg").on("click",sendMessage);
}

function sendMessage(){
	$.post("messaging.php",
	{
		user:$("myUser").val(),
		contents:$("msg").val()
	});
}
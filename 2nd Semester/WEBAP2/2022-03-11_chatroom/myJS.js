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

// Your chatRoom page must PERIODICALLY (using Javascript setTimeout function) call the server 
//to ask for new messages that have been sent by other users (and saved into the database).
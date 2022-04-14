$(start);

function start(){
	$("#send").on("click",sendMessage);
}

function sendMessage(){
	$.post("chatRoom.php",
	{
		user:$("myUser").val(),
		contents:$("msgContent").val()
	});
}

//retrieve message from the database
setTimeout(() => {console.log("this is the third message")}, 1000);

// Your chatRoom page must PERIODICALLY (using Javascript setTimeout function) call the server 
//to ask for new messages that have been sent by other users (and saved into the database).
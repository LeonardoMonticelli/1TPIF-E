var lastMessages = [];

$("#sendMessage").on('click', function() {
  var content = $("#message").val();
  $.post( "messages.php", { message: content } );
  alert("message sent!"+content);
});

function checkDatabase() {
  $.getJSON( "messages.php", function( data ) { 

    var items = [];
    $.each( data, function( key, val ) {

      if(!lastMessages.includes(JSON.stringify(val))) {

        lastMessages.push(JSON.stringify(val));
        items.push("<tr>");
        items.push( "<td>" + val.msgUser + "</td>" ); //msgUser is the same as the one in the table
        items.push( "<td>" + val.msgText + "</td>" );
        items.push("<tr>");

      }
    });
   
    for(var i = 0; i < items.length; i++) {
      var item = items[i];
      $('#chatBox > tbody:last-child').append(item);
    }
  });
}

setInterval(checkDatabase, 500);
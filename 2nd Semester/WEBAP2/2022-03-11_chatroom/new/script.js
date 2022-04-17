var lastMessages = [];

$("#sendMessage").on('click', function() {
  var content = $("#message").val();
  $.post( "messages.php", { message: content } );
});

function checkDatabase() {
  $.getJSON( "messages.php", function( data ) { 

    var items = [];
    $.each( data, function( key, val ) {

      if(!lastMessages.includes(JSON.stringify(val))) {

        lastMessages.push(JSON.stringify(val));
        items.push("<tr>");
        items.push( "<td>" + val.username + "</td>" );
        items.push( "<td>" + val.content + "</td>" );
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
var lastMessages = [];

$("#send").on('click', function() {
  var content = $("#msgContent").val();
  $.post( "messages.php", { msgContent: content } );
});

function checkDB() {
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
      $('#chatTable > tbody:last-child').append(item);
      
    }
  });
}

setInterval(checkDB, 500);

// Your chatRoom page must PERIODICALLY (using Javascript setTimeout function) call the server 

//to ask for new messages (and saved into the database).
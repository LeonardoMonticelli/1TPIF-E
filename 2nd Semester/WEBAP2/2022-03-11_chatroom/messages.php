<?php
$conn= new mysqli("localhost","root","","chat");

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}


if(isset($_POST["msgContent"], $_SESSION["username"])) { // Store the message in the DB

    date_default_timezone_set('Europe/Luxembourg');
  
    $insertInDB = $conn->prepare("INSERT INTO messages (fromUser, msgText, msgTime) VALUES (?, ?, NOW())");
    $insertInDB->bind_param("ss", $_SESSION["username"], $_POST["msgContent"]);
    $insertInDB->execute();
  
  } else { // recent messages
  
    $sqlSelect = "SELECT * FROM messages WHERE msgTime > date_sub(now(), interval 2 second);";
    $result = mysqli_query($conn, $sqlSelect);
    $json_results = [];
    
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        array_push($json_results, $row);
      }
    }
  
    echo json_encode($json_results);
  }
?>
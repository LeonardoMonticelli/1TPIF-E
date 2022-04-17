<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chat";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["message"], $_SESSION["username"])) {

  date_default_timezone_set('Asia/Calcutta');
  $stmt = $conn->prepare("INSERT INTO messages (msgUser, msgText, msgTime) VALUES (?, ?, NOW())");
  $stmt->bind_param("ss", $_SESSION["username"], $_POST["message"]);
  $stmt->execute();

} else { 

  $sql = "SELECT * FROM messages WHERE msgTime > date_sub(now(), interval 2 second);"; 
  $result = mysqli_query($conn, $sql);
  $json_results = [];
  
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      array_push($json_results, $row);
    }
  }

  echo json_encode($json_results);
}
?>
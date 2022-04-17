<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["message"], $_SESSION["username"])) { // Store message in DB
  date_default_timezone_set('Europe/Berlin');
  $stmt = $conn->prepare("INSERT INTO messages (username, content, messagetime) VALUES (?, ?, NOW())");
  $stmt->bind_param("ss", $_SESSION["username"], $_POST["message"]);
  $stmt->execute();
} else { // Select recent messages
  $sql = "SELECT * FROM messages WHERE messagetime > date_sub(now(), interval 2 second);"; // select every row where messagetime is lower than past 2 seconds
  $result = mysqli_query($conn, $sql);
  $json_results = [];
  
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      array_push($json_results, $row);
    }
  }

  echo json_encode($json_results);
}
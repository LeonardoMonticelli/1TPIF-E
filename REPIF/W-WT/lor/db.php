<?php
$servername = "192.168.6.220"; // Server name
$username = "webserver"; // Username
$password = "mno"; // Password

$conn = null; // Connection

try {
  $conn = new PDO("mysql:host=$servername;dbname=lory", $username, $password); // Create connection
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception
} catch(PDOException $e) { // If connection fails
  echo "Connection failed: " . $e->getMessage(); // Error message
}

<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) die(); // If session variable not set, redirect to login page.
require("db.php"); // Connect to the database.

if(!isset($_GET["HostName"])) exit("No HostName"); // If the HostName variable is not set, redirect to the main page.

$results = $conn->prepare("SELECT * FROM `group` WHERE HostName = ?"); // Prepare the SQL statement.
$results->bindParam(1, $_GET["HostName"], PDO::PARAM_STR); // Bind the HostName variable.
$results->execute(); // Execute the SQL query.
$results = $results->fetchAll(PDO::FETCH_ASSOC); // Fetch the results into an associative array.

echo json_encode($results); // Return the JSON-encoded array.
?>
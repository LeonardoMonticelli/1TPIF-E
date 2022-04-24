<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) die(); // If session not registered, redirect to login page.
require("db.php"); // Connect to the database.
if($_SESSION["admin"] == true) { // If the user is an admin...
    $stmt = $conn->query("SELECT * FROM SmartBox"); // Get all the smartboxes.
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all the results.
    echo json_encode($result); // Return the results.
} else { // If the user is not an admin...
    $sth = $conn->prepare('SELECT a.HostName, b.Description, b.Location FROM SmartBoxAccess a LEFT JOIN SmartBox b ON a.HostName = b.HostName WHERE a.UserNo = ?'); // Get all the smartboxes the user has access to.
    $sth->bindParam(1, $_SESSION["id"], PDO::PARAM_STR); // Bind the user's ID to the query.
    $sth->execute(); // Execute the query.
    $result = $sth->fetchAll(PDO::FETCH_ASSOC); // Fetch all the results.
    echo json_encode($result);  // Return the results.
}
?>
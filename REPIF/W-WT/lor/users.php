<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"]) || $_SESSION["admin"] == false) die(); // If session variable not set, redirect to login page.
require("db.php"); // Connect to the database.

if(isset($_POST["HostName"], $_POST["UserNo"])) { // If the form has been submitted.
    if(isset($_POST["remove"])) { // If the user wants to remove the user.
        $sth = $conn->prepare('DELETE FROM SmartBoxAccess WHERE UserNo = ? AND HostName = ?'); // Prepare the statement.
        $sth->bindParam(1, $_POST["UserNo"], PDO::PARAM_INT); // Bind the parameters.
        $sth->bindParam(2, $_POST["HostName"], PDO::PARAM_STR); // Bind the parameters.
        $sth->execute(); // Execute the statement.
    } else { // If the user wants to add the user.
        $sth = $conn->prepare('INSERT INTO SmartBoxAccess (HostName, UserNo) VALUES (?, ?)'); // Prepare the statement.
        $sth->bindParam(1, $_POST["HostName"], PDO::PARAM_STR); // Bind the parameters.
        $sth->bindParam(2, $_POST["UserNo"], PDO::PARAM_INT); // Bind the parameters.
        $sth->execute(); // Execute the statement.
    }
    die("200"); // Return a success code.
}

if(isset($_GET["hostname"])) { // If the user wants to remove a hostname.
    $sth = $conn->prepare('SELECT u.UserNo, u.Name FROM SmartBoxAccess a LEFT JOIN user u ON a.UserNo = u.UserNo WHERE a.HostName = ?'); // Prepare the statement.
    $sth->bindParam(1, $_GET["hostname"], PDO::PARAM_STR); // Bind the parameters.
    $sth->execute(); // Execute the statement.
    die(json_encode($sth->fetchAll(PDO::FETCH_ASSOC))); // Return the result.
}

if(isset($_GET["all"])) { // If the user wants to remove a hostname.
    die(json_encode($conn->query("SELECT UserNo, Name, FirstName, LastName, Technician, Email FROM user")->fetchAll(PDO::FETCH_ASSOC))); // Return the result.
}

$results = $conn->query("SELECT UserNo, Name FROM user")->fetchAll(PDO::FETCH_ASSOC); // Get all the users.

echo json_encode($results); // Return the results.
?>
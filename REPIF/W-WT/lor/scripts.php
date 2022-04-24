<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"]) || $_SESSION["admin"] == false) die(); // If session variable not set, redirect to login page.
require("db.php"); // Connect to the database.


if(isset($_GET["ScriptName"]) && !isset($_GET["GroupNo"])) { // If the script name is set and the group number is not.
    $sth = $conn->prepare('SELECT b.HostName, g.GroupNo FROM Script s JOIN `use` u ON s.ScriptName = u.ScriptName JOIN `group` g ON g.GroupNo = u.GroupNo JOIN `SmartBox` b ON b.HostName = g.HostName WHERE s.ScriptName = ?'); // Prepare the SQL statement.
    $sth->bindParam(1, $_GET["ScriptName"], PDO::PARAM_STR); // Bind the script name to the query.
    $sth->execute(); // Execute the query.
    die(json_encode($sth->fetchAll(PDO::FETCH_ASSOC))); // Return the result.
}

if(isset($_GET["ScriptNameRemove"], $_GET["HostName"])) { // If the script name and host name are set.
    $sth = $conn->prepare('SELECT u.* FROM Script s JOIN `use` u ON s.ScriptName = u.ScriptName JOIN `group` g ON g.GroupNo = u.GroupNo JOIN `SmartBox` b ON b.HostName = g.HostName WHERE s.ScriptName = ? AND b.HostName = ?'); // Prepare the SQL statement.
    $sth->bindParam(1, $_GET["ScriptNameRemove"], PDO::PARAM_STR); // Bind the script name to the query.
    $sth->bindParam(2, $_GET["HostName"], PDO::PARAM_STR); // Bind the host name to the query.
    $sth->execute(); // Execute the query.
    $result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result.

    $sth = $conn->prepare('DELETE FROM `use` WHERE ScriptName = ? AND GroupNo = ?'); // Prepare the SQL statement.
    $sth->bindParam(1, $result["ScriptName"], PDO::PARAM_STR); // Bind the script name to the query.
    $sth->bindParam(2, $result["GroupNo"], PDO::PARAM_INT); // Bind the group number to the query.
    $sth->execute(); // Execute the query.
    die("done"); // Return the result.
}

if(isset($_GET["ScriptName"], $_GET["GroupNo"])) { // If the script name and group number are set.
    $sth = $conn->prepare('INSERT INTO `use` (ScriptName, GroupNo) VALUES (?, ?)'); // Prepare the SQL statement.
    $sth->bindParam(1, $_GET["ScriptName"], PDO::PARAM_STR); // Bind the script name to the query.
    $sth->bindParam(2, $_GET["GroupNo"], PDO::PARAM_INT); // Bind the group number to the query.
    $sth->execute(); // Execute the query.
    $result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result.
    die("done"); // Return the result.
}

$results = $conn->query("SELECT * FROM script")->fetchAll(PDO::FETCH_ASSOC); // Fetch all the scripts.

echo json_encode($results); // Return the result.
?>
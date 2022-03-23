<?php
//connect to the DB
$dbHost="localhost";
$dbUser="root";
$dbPassword="";
$dbName="WT";

$connection= new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if($connection->connect_error){
    die("Connection failed: ".$connection->connect_error);
}

?>
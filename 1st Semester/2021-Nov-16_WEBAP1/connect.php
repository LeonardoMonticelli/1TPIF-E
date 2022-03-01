<?php
    $dbHost="localhost";
    $dbUser="root";
    $dbPassword="";
    $dbName="wordSuggest";

    $conn= new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }
?>
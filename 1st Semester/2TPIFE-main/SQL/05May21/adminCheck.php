<?php
    if(!isset($_SESSION["isUserLoggedIn"]) || $_SESSION["role"] != "admin"){
        header("location: login.php"); 
        die("Access denied");
    }
?>
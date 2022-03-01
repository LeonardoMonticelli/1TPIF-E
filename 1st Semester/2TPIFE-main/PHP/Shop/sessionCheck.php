<?php
    session_start(); // I can use the $_SESSION array

    if(!isset($_SESSION["isUserLoggedIn"])){
        $_SESSION["isUserLoggedIn"] = false;
        $_SESSION["isAdmin"] = false;
    }

    if(isset($_POST["username"])&& (!empty($_POST["username"]))){
        $_SESSION["isUserLoggedIn"] = true;
        $_SESSION["currentUser"] = $_POST["username"];
        // Write code that findsout IF $_SESSION["currentUser"] is equal TO ANY LINE
        // textfile called "Administrators.txt
    }

    if(isset($_POST["logout"])){
        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] = false;
        $_SESSION["isAdmin"] = false;
    }
?>
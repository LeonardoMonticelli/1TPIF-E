<?php
    session_start();

    if(!isset($_SESSION["isUserLoggedIn"])){
        $_SESSION["isUserLoggedIn"] = false;
    }

    if(isset($_POST["username"])&& (!empty($_POST["username"]))){
        $_SESSION["isUserLoggedIn"] = true;
        $_SESSION["currentUser"] = $_POST["username"];
    }

    if(isset($_POST["logout"])){
        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] = false;
    }
?>
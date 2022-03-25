<?php
    $pageTitle ="Logging you out";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";

    if($_SESSION["isUserLoggedIn"] == true){
        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] = false;
        header("Location: index.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
?>
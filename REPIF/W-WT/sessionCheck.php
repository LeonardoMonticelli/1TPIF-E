<?php
    session_start();

    if(!isset($_SESSION["isUserLoggedIn"])){
        $_SESSION["isUserLoggedIn"] = false;
    }

    if(isset($_POST["logout"])){
        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] = false;
    }
?>
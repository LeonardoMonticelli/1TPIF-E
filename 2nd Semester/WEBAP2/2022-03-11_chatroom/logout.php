<?php
    //end session
    if($_SESSION["isUserLoggedIn"] == true){
        session_unset();
        session_destroy();
        $_SESSION["isUserLoggedIn"] = false;
        header("Location: chatLogin.php");
        exit;
    } else {
        header("Location: chatLogin.php");
        exit;
    }
?>
<?php
    session_start();

    if(!isset($_SESSION["isUserLoggedIn"])){
        $_SESSION["isUserLoggedIn"] = false;
    }
    
    if($_SESSION["isUserLoggedIn"]==false){
        header("Location: index.php");
        exit;
    } 
?>
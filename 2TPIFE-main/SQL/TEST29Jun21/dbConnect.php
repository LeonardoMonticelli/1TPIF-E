<?php
session_start();
if(!isset($_SESSION["userLoggedIn"])){
    $_SESSION["userLoggedIn"] = false;
}
if($_SESSION["userLoggedIn"]){
    if(!isset($_SESSION["shoppingCart"])){
        $_SESSION["shoppingCart"] =[];
    }
    // if(isset($_SESSION["clearCart"])){
    //     $_SESSION["shoppingCart"] = array();
    // }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "wsers2_test";

$connection = mysqli_connect($servername, $username, $password, $dbName);

if (!$connection){
    die("Connection failed: " . mysqli_connect_error());
}
?>
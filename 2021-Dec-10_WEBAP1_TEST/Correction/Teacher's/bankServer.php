<?php

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, "bankaccounts");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET["UserBalance"])){
    $sqlSelect = $conn->prepare("SELECT Balance from ppl where PersonName=?");
    $sqlSelect->bind_param("s",$_GET["UserBalance"]);
    $sqlSelect->execute();
    $res = $sqlSelect->get_result();
    if ($res->num_rows>0)
    {
        $row = $res->fetch_assoc();
        print $row["Balance"];
    }
    else
        print "Unknown user";
}

//if (isset($_GET["UserDeposit"],$_GET["amount"])){
if (isset($_GET["UserDeposit"]) && isset($_GET["amount"])){
    $sqlUpdate = $conn->prepare("Update ppl set Balance=Balance+? where PersonName=?");
    $sqlUpdate->bind_param("is",$_GET["amount"],$_GET["UserDeposit"]);
    $sqlUpdate->execute();    
    print "Hopefully, we saved your money. Rest assured that you are safe with us!";
}

if (isset($_GET["UserWithdraw"],$_GET["amount"])){
    $sqlSelect = $conn->prepare("SELECT Balance from ppl where PersonName=?");
    $sqlSelect->bind_param("s",$_GET["UserWithdraw"]);
    $sqlSelect->execute();
    $res = $sqlSelect->get_result();
    $row = $res->fetch_assoc();
    if ($row["Balance"]-$_GET["amount"]<0)
        print "Error... you cant have that";
    else{
        $sqlUpdate = $conn->prepare("Update ppl set Balance=Balance-? where PersonName=?");
        $sqlUpdate->bind_param("is",$_GET["amount"],$_GET["UserWithdraw"]);
        $sqlUpdate->execute(); 
        print "Your transaction has been recorded!";
    }
}

?>
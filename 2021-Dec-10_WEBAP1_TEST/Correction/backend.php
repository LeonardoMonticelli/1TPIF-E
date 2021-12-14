<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName =  "bankaccounts";

    $connection = new mysqli($servername, $username, $password, $dbName);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if(isset($_GET["UserBalance"])){ 
        $sqlSelect = $connection->prepare("SELECT Balance from ppl where PersonName=?");
        $sqlSelect->bind_param("s", $_GET["UserBalance"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        if($result->num_rows>0){ //check if there is a user with the name you wrote in   
            $row = $result->fetch_assoc();
            print $row["Balance"];//display the balance
        } else {
            print "This user does not exist!";
        }
    }

    if(isset($_GET["UserDeposit"]) && isset($_GET["Amount"])){ //deposit new amount into the account's balance
        $sqlUpdate = $connection->prepare("update ppl set Balance=Balance+? where PersonName=?");
        $sqlUpdate->bind_param("is", $_GET["Amount"],$_GET["UserDeposit"]);
        $sqlUpdate->execute();
        print "Probably your money was deposited into your account.";
    }

    if(isset($_GET["UserWithdraw"])&&isset($_GET["Amount"])){ //withdraw set amount from the account's balance
        $sqlSelect = $connection->prepare("SELECT Balance from ppl where PersonName=?");
        $sqlSelect->bind_param("s", $_GET["UserWithdraw"]);
        $sqlSelect->execute(); //execute the binding
        $result = $sqlSelect->get_result();
        $row = $result->fetch_assoc();

        if($row["Balance"]-$_GET["Amount"]<0){
            print "Error. Not enough funds to withdraw";
        }else{
            $sqlUpdate = $connection->prepare("update ppl set Balance=Balance-? where PersonName=?");
            $sqlUpdate->bind_param("is", $_GET["Amount"],$_GET["UserWithdraw"]);
            $sqlUpdate->execute();
            print "You probably have withdrawn money from your account.";
        }
    }
?>
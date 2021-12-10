<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName =  "bankaccounts";

    $conn = new mysqli($servername, $username, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_GET["User"])){ //display the balance
        $sqlSelect = $conn->prepare("SELECT Balance from ppl where PersonName=?");
        $sqlSelect->bind_param("s", $_GET["User"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        if($result->num_rows>0){ //check if there is a user with the name you wrote in
            while($row = $result->fetch_assoc()){
                print $row["Balance"];
            }
            
            if(isset($_GET["UserDeposit"])&&isset($_GET["Amount"])){ //deposit new amount into the account's balance
                $sqlInsert = $connection->prepare("update ppl set Balance=Balance+? where PersonName=?");
                $sqlSelect->bind_param("is", $_GET["Amount"],$_GET["UserDeposit"]);
                $sqlSelect->execute();
                print "Probably your money was deposited into your account.";
            }
    
            if(isset($_GET["UserWithdraw"])&&isset($_GET["Amount"])){ //withdraw set amount from the account's balance
                $sqlInsert = $connection->prepare("update ppl set Balance=Balance-? where PersonName=?");
                $sqlSelect->bind_param("is", $_GET["Amount"],$_GET["UserWithdraw"]);
                $sqlSelect->execute();
                print "You probably have withdrawn money from your account.";
            }
        } else {
            print "this user does not exist!";
        }
        $sqlSelect->close();
    }
?>
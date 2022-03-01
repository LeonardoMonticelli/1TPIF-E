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
        $sqlSelect = $conn->prepare("SELECT Balance from bankaccounts where PersonName=?");
        
        $sqlSelect->bind_param("s", $_GET["User"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        while($row = $result->fetch_assoc()){
            print $row["Balance"];
        }
        $sqlSelect->close();
    }

    if(isset($_GET["Deposit"])){
        $sqlInsert = $connection->prepare("INSERT into bankaccounts(PersonName,Balance) values(?,?);");
    }

?>
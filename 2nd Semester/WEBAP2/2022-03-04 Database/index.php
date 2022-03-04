<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bankAccounts";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } 
    //select 
    $sql = $conn->prepare("SELECT PersonId, PersonName, Balance FROM ppl");
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<br> id: ".$row["PersonId"]. " - Name: ".$row["PersonName"]." - Balance: ".$row["Balance"]."<br>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
?>
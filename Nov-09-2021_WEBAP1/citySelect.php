<?php

if(isset($_GET["Country"])){
        
    $servername="localhost";
    $username="root";
    $password="";
    $db="firstajax";

    $conn = new mysqli($servername, $username, $password, "firstajax");

    //Check connection 
    if($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * from cities where Country=?");
    $myCountry = $_GET["Country"];

    $stmt->bind_param("i",$myCountry);

    $stmt->execute();
    $res=$stmt->get_result();
    // print("This is a list of all known cities");
    print("<br>");
    print("<select>");
    while($row = $res->fetch_assoc()){
        ?>
        <option><?= $row["CityName"]?></option>
        <?php
    }
    print("</select>");

    $stmt->close();
}
?>
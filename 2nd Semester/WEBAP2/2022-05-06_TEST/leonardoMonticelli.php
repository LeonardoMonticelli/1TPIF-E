<?php

header('Content-Type: application/json; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "countries";


$connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = $connection->query("SELECT * FROM countries, cities WHERE countries.CountryID=cities.CountryID");
$row = $result->fetch_assoc();
$obj = json_decode($_GET["Country"], false);


if($_GET["Country"]==$row["CountryName"]){
    $sqlSelect = $connection->prepare("SELECT * FROM countries, cities WHERE countries.CountryID=cities.CountryID and countries.CountryName=?");
    $sqlSelect->bind_param("s", $_GET["Country"]);

    $result = mysqli_query($connection, $sqlSelect);
    
    $json_results = [];
        
    if (mysqli_num_rows($result) > 0) {
    
        while($row = mysqli_fetch_assoc($result)) {
            array_push($json_results, $row);
        }
    
    }
      
    echo json_encode($json_results);
} else{

    $result = mysqli_query($connection, "SELECT * FROM countries, cities WHERE countries.CountryID=cities.CountryID");
    
    $json_results = [];
        
    if (mysqli_num_rows($result) > 0) {
    
        while($row = mysqli_fetch_assoc($result)) {
            array_push($json_results, $row);
        }
    
    }
      
    echo json_encode($json_results);

}

?>
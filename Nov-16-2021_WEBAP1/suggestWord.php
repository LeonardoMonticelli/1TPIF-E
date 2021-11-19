<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "words";

    $connection = mysqli_connect($servername, $username, $password, $dbName);

    if(!$connection){
		die("Error: Failed to connect to database");
    }


    if(isset($_GET["startChars"])){
        print("words that start with ".$_GET["startChars"]);

        $char = $_GET["startChars"]."%"; //the search bar value plus anything that comes after

        $sql=$connection->prepare("SELECT Word from EnglishWords where Word like ? LIMIT 10"); //select the content inside the DB
        $sql->bind_param("s", $char); //binded the question mark with whatever you wrote in the search bar
        $select = $sql->execute(); //execute sql command
    
        if($select){ //if select exists
            $result= $sql->get_result(); //then the result will be the result of the sql selection
            while($row=$result->fetch_assoc()){ //while $row will be the result  that will etch the next row of a result set as an associative array
                print "<br>".$row['Word']."<br>";
            }    
        }
    } else{
        print("you are not searching for anything");
    }
?>
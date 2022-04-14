<?php
    if(isset($_POST["user"],$_POST["contents"]))
    {
        $host=" localhost";
        $user="root";
        $psw="";
        $db="chat";
        $connection= new mysqli($host,$user,$psw,$db);
        
        if($connection->connect_error){
            die("Connection failed: ".$connection->connect_error);
        }
    }

?> 
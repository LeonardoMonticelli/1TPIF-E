<?php
    if(isset($_GET["startChars"])){
        print("words that start with ".$_GET["startChars"]);
    } else{
        print("you are not searching for anything");
    }
?>
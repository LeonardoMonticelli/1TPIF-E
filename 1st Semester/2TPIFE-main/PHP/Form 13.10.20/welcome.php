<?php 
    echo ("Welcome! You just filled in a form <br>") ;

    foreach ($_GET as $key => $value)
    {
        echo $key." ".$value."<br>";
    }
?>
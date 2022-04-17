<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <?php
        if(isset($pageTitle)){
    ?>
        <title><?=$pageTitle?></title>
    <?php
        }
    ?>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
</head>

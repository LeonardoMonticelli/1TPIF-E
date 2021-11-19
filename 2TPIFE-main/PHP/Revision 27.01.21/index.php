<?php
    session_start();
    if(!isset($_SESSION['sumNumbers'])) $_SESSION['sumNumbers'] = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>revision</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <form action="" method="get">
        <input type="text" name="sum" id="">
        <input type="submit" value="ADD">
    </form>
    <?php
        if(isset($_GET['sum'])){
            $_SESSION['sumNumbers'] += $_GET['sum'];
        }
        echo($_SESSION['sumNumbers']);
    ?>
</body>
</html>
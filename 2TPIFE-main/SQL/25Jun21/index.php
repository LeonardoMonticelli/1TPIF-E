<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>button exercise for the test</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php 
        session_start();

        if(!isset($_SESSION["hiddenButtons"]) || isset($_POST["clear"])) {
            $_SESSION["hiddenButtons"] = [];
        }

        $array = ["Ducks", "Pigs", "Penguins"];

        for($a=0;$a<sizeof($array);$a++){
            if(isset($_POST[$array[$a]])){
                array_push($_SESSION["hiddenButtons"], $a);

            }
            if (!in_array($a,$_SESSION["hiddenButtons"])){
    ?>
    <form method="post">
        <input type="hidden" name="<?= $array[$a]?>">
        <input type="submit" value="<?= $array[$a]?>"/>
    </form>

    <?php
        }}
        if(isset($_POST["display"])){
            var_dump($_SESSION["hiddenButtons"]);
        } 
    ?>
    <br>
    <form action="" method="post">
        <input type="submit" value="Clear session" name="clear">
    </form>
    <form action="" method="post">
        <input type="submit" value="Show session" name="display">
    </form>
</body>
</html>
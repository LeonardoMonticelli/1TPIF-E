<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        if(isset($_POST["Username"],$_POST["Pswd"])){
            include_once("dbConnect.php");
        }
    ?>
    <form action="" method="post">
        Username: <input type="text" name="Username" id="">
        Password: <input type="text" name="Pswd" id="">
        <input type="submit" name="Login" id="">
    </form>
</body>
</html>
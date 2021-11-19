<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <h1>Login</h1>
    <?php
        include_once "dbConnect.php";
        include_once "navBar.php";
        if(!$_SESSION["userLoggedIn"]){
    ?>
    <form method="post">
        <input name="username">
        <input type="submit" value="login">
    </form>
    <?php 
        } else{
            print $_SESSION["currentUser"];
        }
        if(isset($_POST["username"])){
            print "you are now logged in";
            $_SESSION["userLoggedIn"] = true;
            $_SESSION["currentUser"] = $_POST["username"];
            header("Location: login.php");
        } 
    ?>
</body>
</html>
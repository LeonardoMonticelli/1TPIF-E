<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        include_once "DBconnect.php";
        if(isset($_POST["Logout"])){
            session_unset();
            session_destroy();
            $_SESSION["isUserLoggedIn"]=true;
        }
        if(isset($_POST["Username"],$_POST["Pswd"])){
            include_once("dbConnect.php");
            $sql = $connection->prepare("Select * from ppl where username=?");
            if(!$sql){
                die("error in your sql");
            }
            $sql->bind_param("s",$_POST["username"]);
            if(!$sql->execute()){
                die("Error executing sql statement");
            }
            $result=$sql->execute();
            if($result->$num_rows==0){
                echo "Your username is not in our database";
            } else{
                $row = $result->fetch_assoc();
                if(password_verify($_POST["Pswd"],$row["Pswd"])){
                    echo "Your typed the correct password. You are now logged in";
                    $_SESSION["isUserLoggedIn"]=true;
                } else {
                    echo "wrong password.";
                }
            }
        }
        if($_SESSION["isUserLoggedIn"]){
            ?>
                <h1>Logout</h1>
                <form action="" method="post">
                <input type="submit" name="Logout" id="">
                </form>
            <?php
        } else{
            ?>
                <h1>Please log in</h1>
                <form action="" method="post">
                Username: <input type="text" name="Username" id="">
                Password: <input type="text" name="Pswd" id="">
                <input type="submit" name="Login" value="login">
                </form>
                <form action="Signup.php">
                    <input type="submit" value="Go to signup">
                </form>
           <?php 
        }
    ?>
</body>
</html>
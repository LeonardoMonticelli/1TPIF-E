<?php //head
    $pageTitle ="Home";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
?>

    <body>
        <?php //insert php
            if($_SESSION['isUserLoggedIn']==true){
                include_once "navigationBar.php";
            }
        ?>

        <?php
            if(!$_SESSION['isUserLoggedIn']){?>

                <div class="form-group m-3">
                    <div>Login</div>
                    <form method="post">

                        <label>Username</label>
                        <input name="username">

                        <label>Password</label>
                        <input name="password" type="password">
                        <input type="submit" value="Login">

                    </form>
                </div>
                <a class="m-3" href="signup.php">Don't have an account?</a>
            <?php
                if(isset($_POST["username"],$_POST["password"])){

                    $sql = $connection->prepare("select * from user where UserName=?");
                    if(!$sql){
                        die("Error in the sql");
                    }

                    $sql->bind_param("s", $_POST["username"]);
                    if(!$sql->execute()){
                        die("Error executing the sql statement");
                    }
                    
                    $result = $sql->get_result();
                    
                    if($result->num_rows==0){
                        print "Your username is not in our database";
                    } else {
                        $row = $result->fetch_assoc();
                        var_dump($row);
                        if(password_verify($_POST["password"],$row["Password"])){
                            print "You are now logged in";
                            $_SESSION["isUserLoggedIn"] = true;
                            $_SESSION["currentUser"] = htmlentities($_POST["username"]);
                            header("Location: index.php");
                        } else {
                            print "The data you provided does not match with the one in our servers.";
                        }
                    }
                }

            }
            else{
                    echo "Welcome " .$_SESSION['currentUser'];
                    ?>
                    <?php
            }
        ?>
    </body>
</html>
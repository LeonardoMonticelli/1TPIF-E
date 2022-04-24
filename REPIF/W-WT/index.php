<?php //head
    session_start();

    $pageTitle ="Home";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";

    if(!isset($_SESSION["isUserLoggedIn"])){
        $_SESSION["isUserLoggedIn"] = false;
    }
    if($_SESSION['isUserLoggedIn']==true){
        include_once "navigationBar.php";
    }
?>

    <body>

        <?php
            if(!$_SESSION['isUserLoggedIn']){?>
                
                <div class="form-group m-3">
                    <form method="post">

                        <div class="input-group">

                        <span class="input-group-text">Username</span>
                        <input type="text" class="form-control" name="username" placeholder="username">

                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" name="password" placeholder="password">

                        <input type="submit" value="Login">
                        </div>

                    </form>
                </div>

                <a class="m-3" href="signup.php">Don't have an account?</a>

            <?php
                if(isset($_POST["username"],$_POST["password"])){

                    $sql = $connection->prepare("select * from users where UserName=?");

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

                        if(password_verify($_POST["password"],$row["Password"])){

                            print "You are now logged in";
                            $_SESSION["isUserLoggedIn"] = true;
                            $_SESSION["currentUser"] = htmlentities($_POST["username"]);
                            $_SESSION["userIsAdmin"] = $row["Technician"];
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
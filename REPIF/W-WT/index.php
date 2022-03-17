<?php //connect to the DB
    $dbHost="localhost";
    $dbUser="root";
    $dbPassword="";
    $dbName="WT";

    $conn= new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }
?>

<?php //head
    $pageTitle ="home";
    include_once "htmlHead.php";
?>

<body>
    <?php //insert php
        include_once "sessionCheck.php";
        if($_SESSION["isUserLoggedIn"]==true){
            include_once "navigationBar.php";
        }
    ?>
</body>

<?php
    if(!$_SESSION['isUserLoggedIn']){?>
        <div class="">
        <form method="post">
            <label>Username</label>
            <input name="username">
            <label>Password</label>
            <input name="password" type="password">
            <input type="submit" value="Login">
        </form>
    </div>
    <?php
        if(isset($_POST["username"],$_POST["password"])){

            $sql = $conn->prepare("select * from users where UserName=?");
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
                    header("Location: index.php"); // to reload the page after logging in
                } else {
                    print "The data you provided does not match with the one in our servers.";
                }
            }
        }

    }
    else{
            echo "Welcome " .$_SESSION['currentUser'];
            ?>
                <form method="post">
                    <input type="submit" name="logout" value="Logout">
                </form>
            <?php
    }
?>

</html>
<?php //head
    $pageTitle ="Sign up";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
?>

<body>
    <?php //insert nav bar
        if(isset($_POST["goBack"])){
            header("location: index.php");
        }

        if(!empty($_POST["userNameCreate"])&&!empty($_POST["firstNameCreate"])&&!empty($_POST["lastNameCreate"])&&!empty($_POST["emailCreate"])&&!empty($_POST["passwordCreate"])){ //create 

            $password = $_POST['passwordCreate'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sqlCreate = $connection->prepare("INSERT INTO `users` (`UserName`, `FirstName`, `LastName`, `Email`, `Password`) VALUES (?, ?, ?, ?, ?)");

            if(!$sqlCreate){
                die("Error: the USER cannot be created");
            }

            $sqlCreate->bind_param("sssss",  $_POST["userNameCreate"], $_POST["firstNameCreate"], $_POST["lastNameCreate"], $_POST["emailCreate"], $hashedPassword);
            $sqlCreate->execute();

            header("Location: index.php");
            exit;
        }
    ?>
    <div class="">
        <form action="" method="post">
            <input type="hidden" name="goBack">
            <input type="submit" class="btn btn-secondary mb-3" value="Go back">
        </form>
    </div>
    <div class="d-flex justify-content-left m-3"> 
    <form method="post">

        <div class="form-group mb-3">
            <label for="">Username</label>
            <input type="text" class="form-control" name="userNameCreate" placeholder="username">
        </div>

        <div class="form-group mb-3">
            <label for="">First Name</label>
            <input type="text" class="form-control" name="firstNameCreate" placeholder="first name">
        </div>

        <div class="form-group mb-3">
            <label for="">Last Name</label>
            <input type="text" class="form-control" name="lastNameCreate" placeholder="last name">
        </div>

        <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="email" class="form-control" name="emailCreate" placeholder="example@example.com">
        </div>

        <div class="form-group mb-3">
            <label for="">Password</label>
            <input type="password" class="form-control" name="passwordCreate" placeholder="please type a password">
            <div id="emailHelp" class="form-text">We'll never share your password with anyone else.</div>
        </div>

        <button type="submit" class="btn btn-success">Sign up</button>

    </form>
    </div>
</body>
</html>
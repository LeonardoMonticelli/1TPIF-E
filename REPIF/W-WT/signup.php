<?php //head
    $pageTitle ="Sign up";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
?>

<body>
    <?php //insert nav bar
        if($_SESSION["isUserLoggedIn"]==true){
            header("Location: index.php");
            exit;
        }
    ?>
    <div class="d-flex justify-content-left m-3"> 
        <form method="post">
                <div class="form-group mb-3">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="createUsername" placeholder="Username">
                </div>

            <div class="form-group mb-3">
                <label for="">First name</label>
                <input type="text" class="form-control" name="createFirstName" placeholder="First name">
            </div>

            <div class="form-group mb-3">
                <label for="">Last name</label>
                <input type="text" class="form-control" name="createLastName" placeholder="Last name">
            </div>
            
            <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="email" class="form-control" name="createEmail" placeholder="Email">
            </div>

            <div class="form-group mb-3">
                <label for="">New Password</label>
                <input type="password" class="form-control" name="newPassword" placeholder="New password">
            </div>

            <div class="form-group mb-3">
                <label for="">Repeat Password</label>
                <input type="password" class="form-control" name="repeatPassword" placeholder="Repeat password">
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
</body>
</html>
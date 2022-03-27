<?php //head
    $pageTitle ="Administration";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
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
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="createUsername" placeholder="username">
                </div>

            <div class="form-group">
                <label for="">First name</label>
                <input type="text" class="form-control" name="createFirstName" placeholder="first">
            </div>

            <div class="form-group">
                <label for="">Last name</label>
                <input type="text" class="form-control" name="createLastName" placeholder="last name">
            </div>
            
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name="createEmail" placeholder="Email">
            </div>

            <!-- <div class="form-group">
                <label for="">Technician</label>
                    <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Technician?
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" value="1">Yes</a>
                        <a class="dropdown-item" value="0">No</a>
                    </div>
                </div>
            </div> -->

            <div class="form-group">
                <label for="">New Password</label>
                <input type="password" class="form-control" name="newPassword" placeholder="new password">
            </div>

            <div class="form-group">
                <label for="">Repeat Password</label>
                <input type="password" class="form-control" name="repeatPassword" placeholder="repeat password">
            </div>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</body>
</html>
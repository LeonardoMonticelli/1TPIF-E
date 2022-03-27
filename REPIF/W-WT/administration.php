<?php //head
    $pageTitle ="Administration";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
?>

<body>
    <?php //insert nav bar
        if($_SESSION["isUserLoggedIn"]==false){
            header("Location: index.php");
            exit;
        } else {
            include_once "navigationBar.php";
        }
    $result = $connection->query("SELECT * from user");

    if ($result) {
    
        ?>
            <table class="table">
                <thead>
                    <tr>

                        <th scope="col">UserNo</th>
                        <th scope="col">UserName</th>
                        <th scope="col">FirstName</th>
                        <th scope="col">LastName</th>
                        <th scope="col">Technician</th>
                        <th scope="col">Email</th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) {?>                           
                        <tr>

                        <th scope="row"><?=  $row["UserNo"] ?></th>
                        <td><?=  $row["UserName"] ?></td>
                        <td><?=  $row["FirstName"] ?></td>
                        <td><?=  $row["LastName"] ?></td>
                        <td><?=  $row["Technician"] ?></td>
                        <td><?=  $row["Email"] ?></td>
                            <td>                                
                                <form method="POST">
                                    <input type="hidden" name="editUser" value="<?= $row["UserNo"] ?>">
                                    <input type="submit" value="Edit">
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="deleteUser" value="<?= $row["UserNo"] ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
<?php
        if(isset($_POST["deleteUser"])) {
            $deletePinVal = intval($_POST["deleteUser"]);
            $sqlDelete = $connection->prepare("DELETE FROM pin where UserNo=?");
            if(!$sqlDelete){
                die("Error: the PIN cannot be deleted");
            }
            $sqlDelete->bind_param("i", $deletePinVal);
            $sqlDelete->execute();
        }
        if(isset($_POST["editUser"])){
            $editPinVal = intval($_POST["editUser"]);
            $sqlSelect = $connection->prepare("SELECT HostName, UserNo, Input, Designation FROM pin WHERE UserNo=?");
            $sqlSelect->bind_param("i", $editPinVal);
            $sqlSelect->execute();
            $result = $sqlSelect->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
        }
//manage users
        // $createUserVal = intval($_POST["createUser"]);
        $sqlSelect = $connection->prepare("SELECT * FROM user WHERE UserNo=?");
        $sqlSelect->bind_param("i", $createUserVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        while ($row = $result->fetch_assoc()) {
?>  
    <table class="table">
        <thead>
            <tr>

                <th scope="col">UserNo</th>
                <th scope="col">UserName</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
                <th scope="col">Technician</th>
                <th scope="col">Email</th>

            </tr>
        </thead>
    <?php
        }
    }
    ?>

    <div class="d-flex justify-content-left m-3">
        <form method="post" >

        <div class="form-group">
            <label for="">Current Password</label>
            <input type="password" class="form-control" name="currentPassword" placeholder="current password">
        </div>

        <div class="form-group">
            <label for="">New Password</label>
            <input type="password" class="form-control" name="newPassword" placeholder="new password">
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="repeatPassword" placeholder="repeat password">
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>

        </form>
    </div>

<?php
if(!empty($_POST["currentPassword"])&&$_POST["newPassword"]==$_POST["repeatPassword"]){

    $sql=$connection->prepare("UPDATE user SET `Password` = ? WHERE username = ?");

    if(!$sql){
        echo"Error in your sql<br>";
    }

    $hashedPassword = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);

    $sql->bind_param("ss", $hashedPassword, $_SESSION["currentUser"]);

    $check=$sql->execute();

    if(!$check){
        echo "sqlerr";
        echo $sql->error;
    }

    echo "Password updated succesfully";

} else if(isset($_POST["currentPassword"]) && empty($_POST["currentPassword"])){

    echo "Please type your password properly";

} else if(isset($_POST["currentPassword"]) && $_POST["newPassword"]=!$_POST["repeatPassword"]){

    echo "Please type your password properly or the new password does not match";

}

?>
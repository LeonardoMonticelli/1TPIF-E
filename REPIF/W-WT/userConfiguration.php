<?php //head
    $pageTitle ="Administration";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";

    //show current user

    //change current password button
    //if button pressed, show the form

?>
<div class="d-flex justify-content-left m-3">
    <form method="post" >

    <div class="form-group mb-3">
        <label for="">Current Password</label>
        <input type="password" class="form-control" name="currentPassword" placeholder="current password">
    </div>

    <div class="form-group mb-3">
        <label for="">New Password</label>
        <input type="password" class="form-control" name="newPassword" placeholder="new password">
    </div>

    <div class="form-group mb-3">
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
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
    ?>
</body>

<?php
//allow user to change their password
?>  <div class="">
    <form method="post">

        <label><?=$_SESSION["currentUser"]?></label>

        <div>

            <label>Current password</label>

            <input name="currentPassword" type="password">

        </div>
        <div>

            <label>New password</label>

            <input name="newPassword" type="password">

        </div>
        <div>

            <label>Repeat new password</label>

            <input name="repeatPassword" type="password">

        </div>
        <input type="submit" value="NewPassword">

    </form>
</div>
<?php
if(!empty($_POST["currentPassword"])&&$_POST["newPassword"]==$_POST["repeatPassword"]){

    $sql=$connection->prepare("UPDATE users SET `Password` = ? WHERE username = ?");

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
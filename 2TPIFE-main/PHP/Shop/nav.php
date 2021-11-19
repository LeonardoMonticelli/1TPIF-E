<?php
    include_once "functions.php";
?>
<div class="navigation">
        <?php
            if(!isset($_SESSION["isUserLoggedIn"])){
                $_SESSION["isUserLoggedIn"] = false;
            }
            $navigationLinks=["home.php"=>"Home","shop.php"=>"Products","contact.php"=>"Contact"];
            foreach ($navigationLinks as $key => $value) {
                    addNavLink($key,$value);
            }
            if(!$_SESSION['isUserLoggedIn']){?>
                <div class="">
                <form method="post">
                    <label>Please type your username</label>
                    <input name="username">
                    <input type="submit" value="Login">
                </form>
            </div>
            <?php
            }
            else{
                    echo "You're now logged in " .$_SESSION['currentUser'];
                    ?>
                        <form method="post">
                            <input type="submit" name="logout" value="Logout">
                        </form>
                    <?php
            }
    ?>
</div>
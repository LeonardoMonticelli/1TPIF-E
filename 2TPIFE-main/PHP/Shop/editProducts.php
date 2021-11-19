<?php 
include_once "sessionCheck.php";
$pageTitle = "Administration page";
include_once "head.php";
?>

<body>
    <?php
        include_once "Navigation.php"
    ?>
    We will add the editing of products here
    <?php
    include_once "displayProducts.php";

    if ($_SESSION["isUserLoggedIn"] && ifUserIsAdmin($_SESSION["currentUser"])){
        ?>
            <form>
                Product Image: <input>
                Product Price: <input>
                Product name: <input>
                Product description: <input>
                <input type="submit">
            </form>
        <?php
    }
    ?>

</body>
</html>
<?php
    session_start();
    if(isset($_GET['userName'])) {
        $_SESSION['user'] = $_GET['userName'];
        $_SESSION['currentUser'] = $_SESSION['user'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='.css'>
    <script src='.js'></script>
</head>
<body>
    <?php            
    if($_SESSION['user']==$admin){
            echo "You're now logged in " .$_SESSION['currentUser'].", welcome! administrator";
        ?>
            <form method="get" action="login.php">
                <input type="submit" name="logout" value="Logout">
            </form>
            <form method="get" action="product.php">
                <input type="submit" name="product" value="Go to Products page">
            </form>
        <?php
    }
    else{
            echo "You're now logged in " .$_SESSION['currentUser'];
        ?>
            <form method="get" action="login.php">
                <input type="submit" name="logout" value="Logout">
            </form>
            <form method="get" action="product.php">
                <input type="submit" name="product" value="Go to Products page">
            </form>
        <?php
    }
    ?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php 
        session_start();

        $overPage = 10;

        if(!isset($_SESSION["pageNumber"])){
            $_SESSION["pageNumber"] = 1;
        }

        if(isset($_POST["previousPage"])){
            $_SESSION["pageNumber"] -= 1;
        }

        if(isset($_POST["nextPage"])){
            $_SESSION["pageNumber"] += 1;
        }

        if($_SESSION["pageNumber"] == $overPage || $_SESSION["pageNumber"] == 0){
            $_SESSION["pageNumber"] = 1;
        }

        if(isset($_POST["nextPage"]) || isset($_POST["previousPage"])){
            ?><title>Page <?= $_SESSION["pageNumber"]?></title><?php
            echo "<h1>You are in page ".$_SESSION["pageNumber"]."</h1>";
        }
        ?>
        <form  method="post">
            <input type="submit" value="Next page" name="nextPage">
        </form> 
        <?php
        if($_SESSION["pageNumber"] != 1){?>
            <form  method="post">
                <input type="submit" value="Previous page" name="previousPage">
            </form>
        <?php }?>

    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
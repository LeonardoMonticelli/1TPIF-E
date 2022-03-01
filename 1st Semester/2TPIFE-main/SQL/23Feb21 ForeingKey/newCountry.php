<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>FK</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        include_once("DBconnect.php");
        if($_SESSION["isUserLoggedIn"]){
            if(isset($_POST["NewCountry"])){
                $sqlinsert=$connection->prepare("INSERT INTO COUNTRIES (CountryName) values (?)");
                $sqlinsert->bind_param("s",$_POST["NewCountry"]);
                $executeResult=$sqlinsert->execute();
                if(!$executeResult){
                    echo "Creation of a new country failed<br>";
                }
            }
        } else {
            echo "ER: access denied, please log in first.";
        }
    ?>
    <form action="" method="post">
        Add a new country:<input name="NewCountry">
        <input type="submit" value="Add">
    </form>
    <?php
        if(isset($_POST["NewCountry"])){
            echo "New country added.";
        }
    ?>
    <form action="Signup.php">
        <input type="submit" value="Go to signup">
    </form>
</body>
</html>
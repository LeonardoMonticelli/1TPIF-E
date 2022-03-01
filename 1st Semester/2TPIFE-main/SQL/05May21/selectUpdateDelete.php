<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        include_once "dbConnect.php";
        if(isset($_POST["newCountry"])){
            $sqlInsert = $connection->prepare("Insert into Countries(C_Name) values(?)");
            if(!$sqlInsert){
                die("Error in sql insert statement");
            }
            $sqlInsert->bind_param("s",$_POST["newCountry"]);
            $sqlInsert->execute();
        }

        ?>
        <form action="" method="post">
            Name of new country to add:<input name="newCountry">
            <input type="submit" value="Add country">
        </form>
        <?php

        $sqlSelect = $connection->prepare("Select * from Countries");
        if(!$sqlSelect){
            print"Error in sql";
            exit();
        }
        $sqlSelect->execute();
        $countriesResult = $sqlSelect->get_result();
        while ($currentCountry =$countriesResult->fetch_assoc()) {
            ?>
                <div><?=$currentCountry["C_Name"]?>
                    <form>
                        <input type="submite" value="Delete">
                    </form>
                </div>
            <?php
        }
    ?>
</body>
</html>
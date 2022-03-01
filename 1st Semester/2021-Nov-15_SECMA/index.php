<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>List people</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        $servername="localhost";
        $username="root";
        $password="";
        $db="people";

        if(isset($_POST["fName"],$_POST["lName"],$_POST["eAddress"])){
            $fileHandle=fopen("people.csv","a");
            fwrite($fileHandle,$_POST["fName"].",".$_POST["lName"].",".$_POST["eAddress"]);
            fclose($fileHandle);
        } else {
    ?>
            <form action="" method="post">
                First Name: <input type="text" name="fName">
                Last Name:<input type="text" name="lName">
                Email Address:<input type="text" name="eAddress">
            </form>
    <?php
        }
    ?>
</body>
</html>
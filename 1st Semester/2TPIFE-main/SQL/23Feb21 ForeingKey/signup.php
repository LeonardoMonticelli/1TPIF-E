<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Signup</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<style>
    .container{
        width:50%
    }
    .myRegistration{
        display:flex;
        flex-wrap:wrap;
        justify-content:space-between;
    }
    .myRegistration label{
        width:50%;
    }
    .bigItem{
        width:80%
    }
</style>
<body>
<?php
    include_once("dbConnect.php");
    if(isset($_POST["FirstName"],
             $_POST["LastName"],
             $_POST["Age"],
             $_POST["Username"],
             $_POST["Pswd1"],
             $_POST["Pswd2"],
             $_POST["ID_Country"]))
             {
            if( $_POST["Pswd1"]== $_POST["Pswd2"]){

                $sql=$connection->prepare("INSERT INTO ppl(LastName,FirstName,Age,Username,Pswd,ID_Country) VALUES(?,?,?,?,?,?)");
                if(!$sql){
                    echo"Error in your sql<br>";
                }
                $sql->bind_param("ssissi",$_POST["LastName"],
                                         $_POST["FirstName"],
                                         $_POST["Age"],
                                         $_POST["Username"],
                                         $_POST["Pswd1"],
                                         $_POST["ID_Country"]);
                $check=$sql->execute();
                if(!$check){
                    echo "sqlerr";
                    echo $sql->error;
                } else{
                    header("Location: login.php?loggedin");
                    die();
                    //echo"We signed you up, check the database";
                }
            }
            else{
                echo"The two passwords do not match, please try again";
            }
            }
    ?>
    <div class="container">
        <form method="post" class="myRegistration">
            <label for="FName">First Name</label> <input  name="FirstName">
            <label for="LName">Last Name</label><input  name="LastName">
            <label for="HowOldAreYou">Age</label><input  name="Age">
            <label for="Usrname">Pick Username</label><input  name="Username">
            <label for="Psw1">Type a Password</label><input type="password"  name="Pswd1">
            <label for="Psw2">Retype a Password</label><input type="password"  name="Pswd2">
            <label for="Country">Choose your country:</label>
            <select name="ID_Country">
                <?php
                    $sqlSelect=$connection->prepare("SELECT * FROM countries");
                    $selectOK=$sqlSelect->execute();
                    if(!$selectOK){
                        echo "Something went wrong when selecting the countries";
                        die();
                    }
                    $countryResult=$sqlSelect->get_result();
                    while($row = $countryResult->fetch_assoc()){
                        ?>
                            <option value="<?=$row["ID_Country"]?>"><?=$row["CountryName"]?></option>
                        <?php
                    }
                ?>
            </select>
            <label for=""></label><input type="submit" class="BigItem" value="Signup" name="Signup">
        </form>
    </div>
    <?php
        if(isset($_POST["Signup"])){
            
        }
    ?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Signup</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<style>
    .container{
        width:50%;
        display:flex;
        flex-wrap:wrap;
        justify-content:space-between;
    }
    .myRegistration{
        width:50%;
    }
    .bigItem{
        width:80%
    }
</style>
<body>
    <?php
    if(isset($_POST["FirstName"],
             $_POST["LastName"],
             $_POST["Age"],
             $_POST["Username"],
             $_POST["Pswd1"],
             $_POST["Pswd2"]))
             {
            if( $_POST["Pswd1"]== $_POST["Pswd2"]){
                include_once("dbConnect.php");
                $sql=$connection->prepare("INSERT INTO users(LastName,FirstName,Age,Username,Pswd) Values(?,?,?,?,?)");
                if(!$sql){
                    print"Error in your sql<br>";
                }
                $sql->bind_param("ssiss",$_POST["LastName"],
                                         $_POST["FirstName"],
                                         $_POST["Age"],
                                         $_POST["Username"],
                                         $_POST["Pswd1"]);
                $check=$sql->execute();
                if(!$check){
                    print $sql->error;
                } else{
                    print"Everything went smoothly, check the database";
                }
            }
            else{
                print"The two passwords do not match, please try again";
            }
            }
    ?>
<h1>Please sign up</h1>
<div class="container">
<form class="myRegistration" method="POST">
   <lable for="FName">First Name</lable> <input  name="FirstName"><BR>
   <lable for="LName">Last Name</lable><input  name="LastName"><BR>
   <lable for="HowOldAreYou">Age</lable><input  name="Age"><BR>
   <lable for="Usrname">Pick Username</lable><input  name="Username"><BR>
   <lable for="Psw1">Type a Password</lable><input type="password"  name="Pswd1"><BR>
   <lable for="Psw2">Retype a Password</lable><input type="password"  name="Pswd2"><BR>
   <input class="bigItem" type="submit" value="Signup">
</form>
 </div>
</body>
</html>
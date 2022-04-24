<?php
session_start();
if(!isset($_SESSION["user"])) { // if "user" session not registered
    header("Location: index.php"); // redirect to login page
    die(); // stop executing any code here.
}
require("db.php"); // include database connection

$msg = ""; // user friendly message

if(isset($_POST["changePwd"])) { // if password is set
   $stmt = $conn->prepare("UPDATE user SET Passwd = ? WHERE UserNo = ?"); // prepare sql statement
   $hash = password_hash($_POST["changePwd"], PASSWORD_DEFAULT); // hash password
   $stmt->bindParam(1, $hash, PDO::PARAM_STR); // bind password
   $stmt->bindParam(2, $_SESSION["id"], PDO::PARAM_INT); // bind user id
   $stmt->execute(); // execute sql statement
   if($stmt) { // if sql statement executed successfully
         $msg = "Password changed successfully"; // set user friendly message
   } else { // if sql statement failed to execute
         $msg = "Error changing password"; // set user friendly message
   }
}

?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
<nav>
         <div class="nav-wrapper">
            <a href="home.php" class="brand-logo">REPIF</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <?php
                if($_SESSION["admin"] == true) { // if user is admin
                   ?>
                    <li><a href="manageusers.php">Manage Users</a></li>
                    <li><a href="managescripts.php">Manage Scripts</a></li>
                   <?php
                }?>
               <li><a href="changepwd.php">Change Password</a></li>
               <li><a href="logout.php">Logout</a></li>
            </ul>
         </div>
      </nav>
    <div class="container">
    <?php
            if(!empty($msg)) { // if message is set
            ?>
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Success!</span>
                        <p><?= $msg ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      ?>


        <div class="row">
            <div class="col s12" style="margin-bottom: 40px">
                <h1 class="header center-on-small-only">Welcome, <?= $_SESSION["user"] ?></h1>
                <h4 class="light text-lighten-4 center-on-small-only">Here are
                    <?= $_SESSION["admin"] == true ? "all" : "your" ?> smartboxes</h4>
            </div>
        </div>
        <div class="row">
         <form class="col s12" method="post">
            <div class="row">
            <div class="input-field col s6">
               <input placeholder="abc123" id="first_name" type="password" class="validate" name="changePwd">
               <label for="first_name">Password</label>
               <input type="submit" class="btn" value="change">
            </div>
         </div>
         </form>
      </div>
        </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>
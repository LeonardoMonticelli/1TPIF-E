<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) { // If session not registered
    header("Location: index.php"); // Redirect to login.php page
    die(); // Stop further execution.
}

if(!isset($_GET["UserNo"])) { // If the UserNo is not set
    header("Location: home.php?badselect"); // Redirect to home.php with error
    die(); // Stop further execution.
} 
require("db.php"); // Include the database connection

// Update
$updated = false; // Set the updated variable to false
if(isset($_POST["post_id"], $_POST["post_name"], $_POST["post_fname"], $_POST["post_lname"], $_POST["post_pwd"], $_POST["post_email"])) { // If the post_id, post_name, post_fname, post_lname, post_pwd, and post_email variables are set
    $updated = true; // Set the updated variable to true
    if(empty($_POST["post_pwd"])) { // If the post_pwd variable is empty
        $sth = $conn->prepare('UPDATE user SET Name=?, FirstName=?, LastName=?, Email=? WHERE UserNo = ?'); // Prepare the SQL statement
        $sth->bindParam(1, $_POST["post_name"], PDO::PARAM_STR); // Bind the post_name variable to the SQL statement
        $sth->bindParam(2, $_POST["post_fname"], PDO::PARAM_STR); // Bind the post_fname variable to the SQL statement
        $sth->bindParam(3, $_POST["post_lname"], PDO::PARAM_STR); // Bind the post_lname variable to the SQL statement
        $sth->bindParam(4, $_POST["post_email"], PDO::PARAM_STR); // Bind the post_email variable to the SQL statement
        $sth->bindParam(5, $_POST["post_id"], PDO::PARAM_INT); // Bind the post_id variable to the SQL statement
        $sth->execute(); // Execute the SQL statement
    } else { // If the post_pwd variable is not empty
        $sth = $conn->prepare('UPDATE user SET Name=?, FirstName=?, LastName=?, Email=?, Passwd=? WHERE UserNo = ?'); // Prepare the SQL statement
        $sth->bindParam(1, $_POST["post_name"], PDO::PARAM_STR); // Bind the post_name variable to the SQL statement
        $sth->bindParam(2, $_POST["post_fname"], PDO::PARAM_STR); // Bind the post_fname variable to the SQL statement
        $sth->bindParam(3, $_POST["post_lname"], PDO::PARAM_STR); // Bind the post_lname variable to the SQL statement
        $sth->bindParam(4, $_POST["post_email"], PDO::PARAM_STR); // Bind the post_email variable to the SQL statement
        $pwd = password_hash($_POST["post_pwd"], PASSWORD_DEFAULT); // Hash the post_pwd variable
        $sth->bindParam(5, $pwd, PDO::PARAM_STR); // Bind the hashed post_pwd variable to the SQL statement
        $sth->bindParam(6, $_POST["post_id"], PDO::PARAM_INT); // Bind the post_id variable to the SQL statement
        $sth->execute(); // Execute the SQL statement
    }
}
// End Update


$sth = $conn->prepare('SELECT * FROM user WHERE UserNo = ?'); // Prepare the SQL statement
$sth->bindParam(1, $_GET["UserNo"], PDO::PARAM_STR); // Bind the UserNo variable to the SQL statement
$sth->execute(); // Execute the SQL statement
if($sth->rowCount() == 0) { // If the SQL statement returns no rows
    header("Location: home.php?noresults"); // Redirect to home.php with error
    die(); // Stop further execution.
}
$result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the SQL statement
?>
<!DOCTYPE html>
<html>
   <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   </head>
   <body>
   <nav>
         <div class="nav-wrapper">
            <a href="home.php" class="brand-logo">REPIF</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <?php
                if($_SESSION["admin"] == true) { // If the user is an admin
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
            if($updated == true) { // If the updated variable is true
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Success!</span>
                            <p>The user has been updated.</p>
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
          <h4 class="light text-lighten-4 center-on-small-only">Editing User #<strong><?= htmlentities($_GET["UserNo"]) ?></strong></h4> 
        </div>
      </div>
      <div class="row">
        <form class="col s12" method="post" id="myForm">
            <div class="row">
                <div class="input-field col s12">
                    <input disabled value="<?= $result["UserNo"] ?>" id="disabled" type="text" class="validate">
                    <input type="hidden" value="<?= $result["UserNo"] ?>" name="post_id">
                    <label for="disabled">UserNo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Placeholder" id="name" type="text" class="validate" value="<?= $result["Name"] ?>" name="post_name">
                    <label for="name">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Placeholder" id="first_name" type="text" class="validate" value="<?= $result["FirstName"] ?>" name="post_fname">
                    <label for="first_name">First Name</label>
                </div>
                <div class="input-field col s6">
                    <input placeholder="Placeholder" id="last_name" type="text" class="validate" value="<?= $result["LastName"] ?>" name="post_lname">
                    <label for="last_name">Last Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Type to reset - Leave empty to ignore" id="pwd" type="password" class="validate" name="post_pwd">
                    <label for="pwd">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Placeholder" id="email" type="text" class="validate" value="<?= $result["Email"] ?>" name="post_email">
                    <label for="email">E-Mail</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <p>
                        <label>
                            <input type="checkbox" name="post_technician" <?= $result["Technician"] == true ? "checked" : "" ?>/>
                            <span>Technician</span>
                        </label>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <a class="waves-effect waves-light btn" id="genConfig" onclick="document.getElementById('myForm').submit();">Update User</a>
                </div>
            </div>
        </form>
      </div>

      </div>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   </body>
</html>

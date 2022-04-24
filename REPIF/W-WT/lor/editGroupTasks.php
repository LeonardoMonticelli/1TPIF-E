<?php
session_start(); // Start the session.

if(!isset($_SESSION["user"])) { //if not admin
    header("Location: index.php");  // go to index.php
    die(); // kill the script
}
require("db.php"); // connect to the database

$msg = ""; // set up a default message
if(isset($_POST["clear_group"])) { // if the clear group button was clicked
    $stmt = $conn->prepare("delete from group_leds where GroupNo = ?"); // prepare the statement
    $stmt->bindParam(1, $_GET["GroupNo"], PDO::PARAM_INT); // bind the GroupNo to the statement
    $stmt->execute(); // execute the statement
    $stmt = $conn->prepare("delete from group_motor where GroupNo = ?"); // prepare the statement
    $stmt->bindParam(1, $_GET["GroupNo"], PDO::PARAM_INT); // bind the GroupNo to the statement
    $stmt->execute(); // execute the statement
    $msg = "The groups has been cleared."; // set the message
}


$query = $conn->prepare('SELECT * FROM `group` WHERE GroupNo = ?'); // Prepare the query
$query->bindParam(1, $_GET["GroupNo"], PDO::PARAM_STR); // Bind the parameters
$query->execute(); // Execute the query
$group = $query->fetch();   // Fetch the results

$added = false; // set added to false
if(isset($_POST["GroupName"])) { // If the form has been submitted
    $sth = $conn->prepare('INSERT INTO `group` (GroupName, Description, HostName) VALUES (?, ?, ?)'); // Prepare the query
    $sth->bindParam(1, $_POST["GroupName"], PDO::PARAM_STR); // Bind the parameters
    $sth->bindParam(2, $_POST["Description"], PDO::PARAM_STR); // Bind the parameters
    $sth->bindParam(3, $_POST["hiddenHostName"], PDO::PARAM_STR); // Bind the parameters
    $sth->execute(); // Execute the query
    $added = true; // set added to true
}

$deleted = false; // set deleted to false
if(isset($_GET["deleteGroupNo"]) && !$added) { // If the form has been submitted
    $sth1 = $conn->prepare('DELETE FROM `group` WHERE GroupNo = ?'); // Prepare the query
    $sth1->bindParam(1, $_GET["deleteGroupNo"], PDO::PARAM_STR); // Bind the parameters
    $sth1->execute(); // Execute the query
    $delete = true; // set deleted to true
}

if(isset($_POST["send"])) { // If the form has been submitted
    foreach($_POST as $key => $value) { // For each led
        if(str_starts_with($key, "led_num_")) { 
            $id = end(explode("_", $key)); // get the id
            $msg = "The LEDs have been setup.";
            $stmt = $conn->prepare("SELECT * FROM `group_leds` leds WHERE pin_number = ? AND GroupNo = ? AND HostName = ?"); // Prepare the query
            $stmt->bindParam(1, $id, PDO::PARAM_INT); // Bind the parameters
            $stmt->bindParam(2, $group["GroupNo"], PDO::PARAM_INT); // Bind the parameters
            $stmt->bindParam(3, $_POST["hiddenHostName"], PDO::PARAM_STR); // Bind the parameters
            $stmt->execute(); // Execute the query
            if($stmt->rowCount() > 0) { // If the led exists, update it
                $stmt = $conn->prepare("UPDATE `group_leds` SET `pin_action` = ? WHERE pin_number = ? and GroupNo = ?"); // Prepare the query
                $stmt->bindParam(1, $value, PDO::PARAM_STR); // Bind the parameters
                $stmt->bindParam(2, $id, PDO::PARAM_INT); // Bind the parameters
                $stmt->bindParam(3, $group["GroupNo"], PDO::PARAM_INT); // Bind the parameters
                $stmt->execute(); // Execute the query
            } else { // If the led doesn't exist, insert it
                $stmt = $conn->prepare("INSERT INTO `group_leds` (pin_number, pin_action, GroupNo, HostName) VALUES (?, ?, ?, ?)"); // Prepare the query
                $stmt->bindParam(1, $id, PDO::PARAM_STR); // Bind the parameters
                $stmt->bindParam(2, $value, PDO::PARAM_STR); // Bind the parameters
                $stmt->bindParam(3, $_GET["GroupNo"], PDO::PARAM_INT); // Bind the parameters
                $stmt->bindParam(4, $_POST["hiddenHostName"], PDO::PARAM_STR); // Bind the parameters
                $stmt->execute(); // Execute the query
            }
        }
    }
    if(isset($_POST["motor_setting"]) && !empty($_POST["motor_setting"])) {
        $stmt = $conn->prepare("SELECT * FROM `group_motor` WHERE GroupNo	 = ?"); // Prepare the query
        $stmt->bindParam(1, $_GET["GroupNo"], PDO::PARAM_INT); // Bind the parameters
        $stmt->execute(); // Execute the query
        if($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("UPDATE `group_motor` SET `group_action` = ? WHERE GroupNo = ?"); // Prepare the query
            $stmt->bindParam(1, $_POST["motor_setting"], PDO::PARAM_STR); // Bind the parameters
            $stmt->bindParam(2, $_GET["GroupNo"], PDO::PARAM_INT); // Bind the parameters
            $stmt->execute(); // Execute the query
        } else {
            $stmt = $conn->prepare("INSERT INTO `group_motor` (group_action, GroupNo) VALUES (?, ?)"); // Prepare the query
            $stmt->bindParam(1, $_POST["motor_setting"], PDO::PARAM_STR); // Bind the parameters
            $stmt->bindParam(2, $_GET["GroupNo"], PDO::PARAM_INT); // Bind the parameters
            $stmt->execute(); // Execute the query
        }
        if(!empty($msg)) { // If the message is not empty
            $msg .= " (and the motor)"; // add the motor to the message
        } else { // If the message is empty
            $msg = "The motor has been setup."; // set the message
        }
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
                if($_SESSION["admin"] == true) {
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
            if(!empty($msg)) {
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


        <?php
            if($added) {
            ?>
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Success!</span>
                        <p>The script has been created</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      ?>

    <?php
            if($deleted == true) {
            ?>
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Success!</span>
                        <p>The group has been deleted</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      ?>

    <?php
            if(isset($_GET["updated"])) {
            ?>
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Success!</span>
                        <p>The script has been updated</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      ?>

        <?php
            if(isset($_GET["UserNoDelete"])) {
            ?>
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Success!</span>
                        <p>The user has been deleted</p>
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
                <h4 class="light text-lighten-4 center-on-small-only">Here are the group settings for <?= $group["GroupName"] ?></h4>
                <h4 class="light text-lighten-4 center-on-small-only">
                    <form method="post">
                        <input type="submit" name="clear_group" value="Clear Group" class="btn">
                    </form>
                </h4>
            </div>
        </div>
        <div class="row">
        <div class="row center-align">
        <div class="col s4"><h5><strong>LED</strong></h5></div>
        <div class="col s4"><h5><strong>Action</strong></h5></div>
      </div>
      <form method="post">
          <input type="hidden" name="hiddenHostName" value="<?= $group["HostName"] ?>">
      <?php
      $switches = [7, 8, 12, 13, 16, 19, 26]; // The switches that are used
      foreach($switches as &$i) { // For each SWITCH
          ?>
        <div class="row center-align">
            <div class="col s4">LED #<?= $i ?></div>

            <div class="col s4">
                <div class="input-field col s12">
                    <select name="led_num_<?= $i ?>">
                        <option value="" disabled selected>Action</option>
                        <option value="ON">Turn on</option>
                        <option value="OFF">Turn off</option>
                        <option value="TOGGLE">Toggle</option>
                        <option value="PULSE">Pulsate</option>
                        <option value="BLINK">Blink</option>
                    </select>
                    <label>Action</label>
                </div>
            </div>
        </div>
          <?php
      }
      ?>

        <div class="row center-align">
            <div class="col s4">Motor</div>

            <div class="col s4">
                <div class="input-field col s12">
                    <select name="motor_setting">
                        <option value="" disabled selected>Setup</option>
                        <option value="TOGGLE">Toggle</option>
                        <option value="ON">ON</option>
                        <option value="OFF">OFF</option>
                    </select>
                    <label>Action</label>
                </div>
            </div>
        </div>

        <div class="row center-align">
        <input class="btn" type="submit" name="send"></input>
      </div>
      </div>
    </form>
        </div>
        <br /><br /><br />
        <hr />
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
<script>
    $(document).ready(function(){ // When the document is ready
        $('select').formSelect(); // fix for materialize select
    });

    $.getJSON( "groups.php", function( data ) { // Get the groups
        var items = []; // Create an array
        $.each( data, function( key, val ) { // For each group
            items.push( `<tr><td>${val.GroupName}</td><td>${val.Description}</td><td>${val.HostName}</td><td><a class="waves-effect waves-light btn" href="managegroups.php?deleteGroupNo=${val.GroupNo}">DELETE</a></td>
                        <td><a class="waves-effect waves-light btn" href="editGroupTasks.php?GroupNo=${val.GroupNo}">EDIT ACTIONS</a></td></tr>`); // Add the group to the array
        });
        
        for(let row of items) { // For each group
            $("#grouplist tbody").append(row); // Add the group to the table
        }
    });
       
</script>

</html>
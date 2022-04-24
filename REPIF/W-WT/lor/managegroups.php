<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) { // Check if a user is logged in.
    header("Location: index.php"); // If not, redirect to the login page.
    die(); // Cancel the rest of the script.
}

$added = false; // Initialize the variable.
require("db.php"); // Connect to the database.
$msg = ""; // Initialize the variable.
if(isset($_POST["GroupName"])) { // Check if the form has been submitted.
    $sth = $conn->prepare('INSERT INTO `group` (GroupName, Description, HostName) VALUES (?, ?, ?)'); // Prepare the SQL statement.
    $sth->bindParam(1, $_POST["GroupName"], PDO::PARAM_STR); // Bind the input to the SQL statement.
    $sth->bindParam(2, $_POST["Description"], PDO::PARAM_STR); // Bind the input to the SQL statement.
    $sth->bindParam(3, $_POST["groupHostname"], PDO::PARAM_STR); // Bind the input to the SQL statement.
    $sth->execute(); // Execute the SQL statement.
    $added = true; // Set the flag.
}

$deleted = false; // Initialize the variable.
if(isset($_GET["deleteGroupNo"]) && !$added) { // Check if the delete button has been clicked.
    $sth1 = $conn->prepare('DELETE FROM `group` WHERE GroupNo = ?'); // Prepare the SQL statement.
    $sth1->bindParam(1, $_GET["deleteGroupNo"], PDO::PARAM_STR); // Bind the input to the SQL statement.
    $sth1->execute(); // Execute the SQL statement.
    $msg = "The group has been deleted"; // Set the message.
}

foreach($_POST as $key => $value) { // Loop through the POST array.
    if(str_starts_with($key, "switch_num_")) { // Check if the key starts with "switch_num_".
        $id = intval(substr($key, 11)); // Get the switch number.
        $newVal = intval($value); // Get the new value.

        $msg = "Set up switches"; // Set the message.

        $stmt = $conn->prepare('DELETE FROM `group_switches` WHERE pin_number = ? and HostName = ?'); // Prepare the SQL statement.
        $stmt->bindParam(1, $id, PDO::PARAM_INT); // Bind the input to the SQL statement.
        $stmt->bindParam(2, $_GET["HostName"], PDO::PARAM_STR); // Bind the input to the SQL statement.
        $stmt->execute(); // Execute the SQL statement.
        
        $stmt = $conn->prepare('SELECT * FROM `group_switches` WHERE pin_number = ? and GroupNo = ? and HostName = ?'); // Prepare the SQL statement.
        $stmt->bindParam(1, $id, PDO::PARAM_INT); // Bind the input to the SQL statement.
        $stmt->bindParam(2, $newVal, PDO::PARAM_INT); // Bind the input to the SQL statement.
        $stmt->bindParam(3, $_GET["HostName"], PDO::PARAM_STR); // Bind the input to the SQL statement.
        $stmt->execute(); // Execute the SQL statement.

        if($stmt->rowCount() > 0) { // Check if the row exists.
            
            $sth = $conn->prepare('UPDATE `group_switches` SET pin_number = ? WHERE GroupNo = ?'); // Prepare the SQL statement.
            $sth->bindParam(1, $id, PDO::PARAM_INT); // Bind the input to the SQL statement.
            $sth->bindParam(2, $value, PDO::PARAM_INT); // Bind the input to the SQL statement.
            $sth->execute(); // Execute the SQL statement.
        } else { // If the row does not exist.
            $sth = $conn->prepare('INSERT INTO `group_switches` (pin_number, GroupNo, HostName) VALUES (?, ?, ?)'); // Prepare the SQL statement.
            $sth->bindParam(1, $id, PDO::PARAM_INT); // Bind the input to the SQL statement.
            $sth->bindParam(2, $value, PDO::PARAM_INT); // Bind the input to the SQL statement.
            $sth->bindParam(3, $_GET["HostName"], PDO::PARAM_STR); // Bind the input to the SQL statement.
            $sth->execute(); // Execute the SQL statement.
        }
    }
}

if(isset($_POST["clearAllSwitches"])) { // Check if the clear all switches button has been clicked.
    $sth = $conn->prepare('DELETE FROM `group_switches` WHERE HostName = ?'); // Prepare the SQL statement.
    $sth->bindParam(1, $_GET["HostName"], PDO::PARAM_STR); // Bind the input to the SQL statement.
    $sth->execute(); // Execute the SQL statement.
    $msg = "All switches have been cleared"; // Set the message.
}

if(isset($_POST["applyConfig"])) { // Check if the apply config button has been clicked.
    require("generate.php"); // Include the generate.php file.
    generateConfig($_GET["HostName"]); // Generate the config.
}

require("db.php"); // Connect to the database.
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
                if($_SESSION["admin"] == true) { // Check if the user is an admin.
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
            if($added) { // Check if the flag is set.
            ?>
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Success!</span>
                        <p>The group has been created</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      ?>

<?php
            if(!empty($msg)) { // Check if the message is not empty.
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
            if(isset($_GET["updated"])) { // Check if the flag is set.
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
            if(isset($_GET["UserNoDelete"])) { // Check if the flag is set.
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
                <h4 class="light text-lighten-4 center-on-small-only">Here are the groups</h4>
            </div>
        </div>
        <div class="row">
        <h5>Current Groups</h5>
            <table id="grouplist">
                <thead>
                    <tr>
                        <th>GroupName</th>
                        <th>Description</th>
                        <th>HostName</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

        </div>
        <h5>Add Group</h5>
        <form class="col s12" method="post" id="myForm">
            <div class="row">
                <div class="input-field col s6">
                    <input id="GroupName" type="text" class="validate" name="GroupName">
                    <label for="GroupName">GroupName</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="Description" type="text" class="validate" name="Description">
                    <label for="Description">Description</label>
                </div>
            </div>
            <div class="row">
                <input type="hidden" class="validate" name="groupHostname" value="<?= $_GET["HostName"] ?>">
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <a class="waves-effect waves-light btn" id="genConfig"
                        onclick="document.getElementById('myForm').submit();">Create Group</a> 
                </div>
            </div>
        </form>
        <br />
        <hr />
        <h5>Switches <form method="post"><input name="clearAllSwitches" class="btn" type="submit" value="Clear"></form></h5>
        <form method="post">
      <?php
      $switches = [22, 10, 5, 17, 27, 4, 9, 11]; // The switches that are used
      foreach($switches as &$i) { // For each SWITCH
          ?>
        <div class="row center-align">
            <div class="col s4">SWITCH #<?= $i ?></div>

            <div class="col s4">
                <div class="input-field col s12">
                    <select name="switch_num_<?= $i ?>">
                        <option value="" disabled selected>Group Number</option> 
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM `group` WHERE HostName = ?"); // Get all the groups
                        $stmt->bindParam(1, $_GET["HostName"], PDO::PARAM_STR); // Bind the hostname
                        $stmt->execute(); // Execute the query
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch the results
                        foreach($result as &$row) { // For each group
                            echo "<option value='" . $row["GroupNo"] . "'>" . $row["GroupName"] . "</option>"; // Print the group name
                        }
                        ?>
                    </select>
                    <label>Action</label>
                </div>
            </div>
        </div>
          <?php
      }
      ?>
        <div class="row center-align">
        <input class="btn" type="submit" name="send"></input>
      </div>
      </div>
    </form>
    <div class="row center-align">
    <h1>Apply Configuration <form method="post"><input name="applyConfig" class="btn" type="submit" value="Apply"></form></h1>
    </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
<script>
    $(document).ready(function(){ // When the document is ready
        $('select').formSelect(); // Initialize the select
    });

    $.getJSON( "groups.php?HostName=<?= $_GET["HostName"] ?>", function( data ) { // Get the groups
        console.log(data) // Print the data
        var items = []; // Create an empty array
        $.each( data, function( key, val ) { // For each group
            items.push( `<tr><td>${val.GroupName}</td><td>${val.Description}</td><td>${val.HostName}</td><td><a class="waves-effect waves-light btn" href="managegroups.php?deleteGroupNo=${val.GroupNo}&HostName=${val.HostName}">DELETE</a></td>
                        <td><a class="waves-effect waves-light btn" href="editGroupTasks.php?GroupNo=${val.GroupNo}">EDIT ACTIONS</a></td></tr>`); // Add the group to the array
        });
        
        for(let row of items) { // For each row
            $("#grouplist tbody").append(row); // Add the row to the table
        }
    });
       
</script>

</html>
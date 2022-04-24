<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"]) || $_SESSION["admin"] == false) { // If session variable "user" does not exist.
    header("Location: index.php"); // Re-direct to index.php
    die(); // Die
}

$added = false; // Set added to false
require("db.php"); // Include the database connection
if(isset($_POST["ScriptName"], $_POST["ScriptPath"], $_POST["ScriptDescription"])) { // If the script name, path, and description are set
    $sth = $conn->prepare('INSERT INTO script (ScriptName, Path, Description) VALUES (?, ?, ?)'); // Prepare the SQL statement
    $sth->bindParam(1, $_POST["ScriptName"], PDO::PARAM_STR); // Bind the script name
    $sth->bindParam(2, $_POST["ScriptPath"], PDO::PARAM_STR); // Bind the script path
    $sth->bindParam(3, $_POST["ScriptDescription"], PDO::PARAM_STR); // Bind the script description
    $sth->execute(); // Execute the SQL statement
    $added = true; // Set added to true
}

$deleted = false; // Set deleted to false
if(isset($_GET["ScriptNameDelete"]) && !$added) { // If the script name is set and the script was not added
    $sth1 = $conn->prepare('DELETE FROM script WHERE ScriptName = ?'); // Prepare the SQL statement
    $sth1->bindParam(1, $_GET["ScriptNameDelete"], PDO::PARAM_STR); // Bind the script name
    $sth1->execute(); // Execute the SQL statement
    $delete = true; // Set deleted to true
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
            if($added) { // If the script was added
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
                        <p>The script has been deleted</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      ?>

    <?php
            if(isset($_GET["updated"])) { // If the script was updated
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
            if(isset($_GET["UserNoDelete"])) { // If the user was not deleted
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
            <div class="col s12">
                <div class="card red lighten-2">
                    <div class="card-content white-text">
                        <span class="card-title">WARNING!</span>
                        <p>
                            To create a Script, you first need:
                            <ul>
                                <li>A use</li>
                                <li>A group</li>
                                <li>A SmartBox</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12" style="margin-bottom: 40px">
                <h1 class="header center-on-small-only">Welcome, <?= $_SESSION["user"] ?></h1>
                <h4 class="light text-lighten-4 center-on-small-only">Here are the scripts</h4>
            </div>
        </div>
        <div class="row">
        <h5>Add Script</h5>
            <table id="smartboxes">
                <thead>
                    <tr>
                        <th>ScriptName</th>
                        <th>Path</th>
                        <th>Description</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

        </div>
        <form class="col s12" method="post" id="myForm">
            <div class="row">
                <div class="input-field col s6">
                    <input id="ScriptName" type="text" class="validate" name="ScriptName">
                    <label for="ScriptName">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="ScriptPath" type="text" class="validate" name="ScriptPath">
                    <label for="ScriptPath">Path</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="ScriptDescription" type="text" class="validate" name="ScriptDescription">
                    <label for="ScriptDescription">Description</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <a class="waves-effect waves-light btn" id="genConfig"
                        onclick="document.getElementById('myForm').submit();">Create Script</a>
                </div>
            </div>
        </form>
        <br /><br /><br />
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
<script>
    $(document).ready(function(){ // When the page is ready
        $('select').formSelect(); // Initialize the select
    }); 

    $.getJSON( "scripts.php", function( data ) { // Get the scripts
        var items = []; // Create an empty array
        $.each( data, function( key, val ) { // For each script
            items.push( `<tr><td>${val.ScriptName}</td><td>${val.Path}</td><td>${val.Description}</td><td><a class="waves-effect waves-light btn" href="managescripts.php?ScriptNameDelete=${val.ScriptName}">DELETE</a></td>
                        <td><a class="waves-effect waves-light btn" href="editScript.php?ScriptName=${val.ScriptName}">EDIT & ACCESS MANAGEMENT</a></td></tr>`); // Add the script to the array
        }); 
        
        for(let row of items) { // For each script
            $("#smartboxes tbody").append(row); // Add the script to the table
        }
    });

    $.getJSON( "groups.php", function( data ) { // Get the groups
        var items = []; // Create an empty array
        $.each( data, function( key, val ) { // For each group
            items.push( `<tr><td>${val.GroupName}</td><td>${val.Description}</td><td>${val.HostName}</td><td><a class="waves-effect waves-light btn" id="genConfig">DELETE</a></td>
                        <td><a class="waves-effect waves-light btn" href="editGroup.php?GroupNo=${val.GroupNo}">EDIT & ACCESS MANAGEMENT</a></td></tr>`); // Add the group to the array
        });
        
        for(let row of items) { // For each group
            $("#grouplist tbody").append(row); // Add the group to the table
        }
    });
       
</script>

</html>
<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"]) || $_SESSION["admin"] == false) { // If session variable "user" does not exist.
    header("Location: index.php"); // Re-direct to index.php
    die(); // Make sure that code below does not get executed when we redirect.
}

$added = false; // Initialize the variable.
require("db.php"); // Connect to the database.
if(isset($_POST["post_name"], $_POST["post_fname"], $_POST["post_lname"], $_POST["post_email"], $_POST["post_pwd"])) { // If the form has been submitted.
    $technician = isset($_POST["post_technician"]); // Check if the technician checkbox is checked.
    $sth = $conn->prepare('INSERT INTO user (Name, FirstName, LastName, Technician, Email, Passwd) VALUES (?, ?, ?, ?, ?, ?)'); // Prepare the SQL statement.
    $sth->bindParam(1, $_POST["post_name"], PDO::PARAM_STR); // Bind the name to the query.
    $sth->bindParam(2, $_POST["post_fname"], PDO::PARAM_STR); // Bind the first name to the query.
    $sth->bindParam(3, $_POST["post_lname"], PDO::PARAM_STR); // Bind the last name to the query.
    $sth->bindParam(4, $technician, PDO::PARAM_INT); // Bind the technician value to the query.  
    $sth->bindParam(5, $_POST["post_email"], PDO::PARAM_STR); // Bind the email to the query.
    $pwd = password_hash($_POST["post_pwd"], PASSWORD_DEFAULT); // Hash the password.
    $sth->bindParam(6, $pwd, PDO::PARAM_STR); // Bind the hashed password to the query.
    $sth->execute(); // Execute the query.
    $added = true; // Set the variable to true.
}

if(isset($_GET["UserNoDelete"])) { // If the user has been deleted.
    $sth1 = $conn->prepare('DELETE FROM SmartBoxAccess WHERE UserNo = ?'); // Prepare the SQL statement.
    $sth1->bindParam(1, $_GET["UserNoDelete"], PDO::PARAM_STR); // Bind the user number to the query.
    $sth1->execute(); // Execute the query.

    $sth2 = $conn->prepare('DELETE FROM user WHERE UserNo = ?'); // Prepare the SQL statement.
    $sth2->bindParam(1, $_GET["UserNoDelete"], PDO::PARAM_STR); // Bind the user number to the query.
    $sth2->execute(); // Execute the query.
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
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   </head>
   <body>
   <nav>
         <div class="nav-wrapper">
            <a href="home.php" class="brand-logo">REPIF</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <?php
                if($_SESSION["admin"] == true) { // If the user is an admin.
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
            if($added) { // If the user has been added. 
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Success!</span>
                            <p>The user has been added</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
      ?>

    <?php
            if(isset($_GET["UserNoDelete"])) { // If the user has been deleted.
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
          <h4 class="light text-lighten-4 center-on-small-only">Here are the users</h4>
        </div>
      </div>
      <div class="row">
      
      <table id="smartboxes">
        <thead>
          <tr>
              <th>Name</th>
              <th>FirstName</th>
              <th>LastName</th>
              <th>Technician</th>
              <th>Email</th>
              <th>Edit</th>
              <th>Delete</th>
          </tr>
        </thead>

        <tbody>
        </tbody>
      </table>

      </div>
      <br/><br/><br/><hr />
      <h5>Add User</h5>
      <form class="col s12" method="post" id="myForm">
            <div class="row">
                <div class="input-field col s6">
                    <input id="name" type="text" class="validate" name="post_name">
                    <label for="name">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="first_name" type="text" class="validate" name="post_fname">
                    <label for="first_name">First Name</label>
                </div>
                <div class="input-field col s6">
                    <input id="last_name" type="text" class="validate" name="post_lname">
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
                    <input id="email" type="text" class="validate" name="post_email">
                    <label for="email">E-Mail</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <p>
                    <label>
                        <input type="checkbox" name="post_technician"/>
                        <span>Technician</span>
                    </label>
                </p>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <a class="waves-effect waves-light btn" id="genConfig" onclick="document.getElementById('myForm').submit();">Create User</a>
                </div>
            </div>
        </form>
      </div>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   </body>
   <script>
   $.getJSON( "users.php?all", function( data ) { // Get all the users.
        var items = []; // Create an empty array.
        $.each( data, function( key, val ) { // For each user.
            items.push( `<tr><td>${val.Name}</td><td>${val.FirstName}</td><td>${val.LastName}</td><td>${(val.Technician == true) ? "<i class='material-icons left green-text'>check</i>" : "<i class='material-icons left red-text'>clear</i>"}</td><td>${val.Email}</td><td><a class="edit edit-light btn" href="editUser.php?UserNo=${val.UserNo}"><i class="material-icons left">edit</i>Edit</a></td><td><a class="edit edit-light btn" href="manageusers.php?UserNoDelete=${val.UserNo}"><i class="material-icons left">close</i>Delete</a></td></tr>`); // Add the user to the array.
        }); 
        
        for(let row of items) { // For each row in the array.
            $("#smartboxes tbody").append(row); // Add the row to the table.
        }
    });
   </script>
</html>

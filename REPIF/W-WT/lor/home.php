<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) { // Check if a user is logged in.
    header("Location: index.php"); // If not, redirect to the login page.
    die(); // Stop the script.
}

require("db.php"); // Connect to the database.

if(isset($_POST["createhost"]) && $_SESSION["admin"] == true) { // If the user submitted the form.
    $hostname = $_POST["createhost"]; // Get the hostname.
    $description = $_POST["createdescription"]; // Get the description.
    $location = $_POST["createlocation"]; // Get the location.

    $sql = $conn->prepare("INSERT INTO SmartBox (HostName, Description, Location) VALUES (:hostname, :descr, :loc)"); // Prepare the SQL statement.
    $sql->bindParam(':hostname', $hostname, PDO::PARAM_STR); // Bind the hostname.
    $sql->bindParam(':descr', $description, PDO::PARAM_STR); // Bind the description.
    $sql->bindParam(':loc', $location, PDO::PARAM_STR); // Bind the location.
    $sql->execute(); // Execute the SQL statement.

    if($sql) { // If the SQL statement executed successfully.
        echo "box created!"; // Display a success message.
    }
    else { // If the SQL statement failed to execute.
        echo "Error creating box!"; // Display an error message.
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
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
            if(isset($_GET["noperms"])) { // If the user does not have permissions.
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Access Denied</span>
                            <p>You are not allowed to manage that smartbox.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
      ?>
            <?php
            if(isset($_GET["badselect"])) { // If the user did not select a smartbox.
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Uh...</span>
                            <p>Invalid SmartBox selected (none)</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
      ?>
                  <?php
            if(isset($_GET["badscript"])) { // If the user did not select a script.
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Uh...</span>
                            <p>Invalid Script selected</p>
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
          <h4 class="light text-lighten-4 center-on-small-only">Here are <?= $_SESSION["admin"] == true ? "all" : "your" ?> smartboxes</h4>
        </div>
      </div>
      <div class="row">
      
      <table id="smartboxes">
        <thead>
          <tr>
              <th>HostName</th>
              <th>Description</th>
              <th>Location</th>
              <th>Edit</th>
              <?php
              if($_SESSION["admin"] == true) { // If the user is an admin.
                 echo "<th>Assign</th>"; // Display the assign column.
              }
              ?>
              <th>Config</th>
          </tr>
        </thead>

        <tbody>
        </tbody>
      </table>
      <?php
      if($_SESSION["admin"] == true) { // If the user is an admin.
          ?>
            <form method="post" class="form">
                HostName: <input type="text" name="createhost"><br>
                Description: <input type="text" name="createdescription"><br>
                Location: <input type="text" name="createlocation"><br>
                <input type="submit" class="btn">
            </form>
          <?php
      }
      ?>
      </div>
      </div>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   </body>
   <script>
   $.getJSON( "smartboxes.php", function( data ) {
        var items = []; // Create an empty array.
        $.each( data, function( key, val ) {
            items.push( `<tr><td>${val.HostName}</td><td>${val.Description}</td><td>${val.Location}</td><td><a class="edit edit-light btn" href="editSmartbox.php?HostName=${val.HostName}"><i class="material-icons left">edit</i>Edit</a> 
</td><?php if($_SESSION["admin"] == true) {?> <td><a class="edit edit-light btn" href="assign.php?HostName=${val.HostName}"><i class="material-icons left">account_box</i>Assign</a></td><?php }?><td><a class="edit edit-light btn" href="managegroups.php?HostName=${val.HostName}"><i class="material-icons left">edit</i>Groups</a></td></tr>`); // Add the smartbox to the array.
        });  // End of each.
        
        for(let row of items) { // For each row.
            $("#smartboxes tbody").append(row); // Append the row to the table.
        }
    });
   </script>
</html>
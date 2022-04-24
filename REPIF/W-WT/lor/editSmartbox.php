<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) { // If session not registered
    header("Location: index.php"); // Redirect to login.php page
    die(); // Stop further execution.
}

if(!isset($_GET["HostName"])) { // If session not registered
    header("Location: home.php?badselect"); // Redirect to login.php page
    die(); // Stop further execution.
}
require("db.php"); // Connect to the database.

$result = null; // Create a variable for the SQL query result.
if($_SESSION["admin"] == false) { // If the user is not an admin,

    $sth = $conn->prepare('SELECT a.HostName, b.Description, b.Location, b.UserNo FROM SmartBoxAccess a LEFT JOIN SmartBox b ON a.HostName = b.HostName WHERE a.HostName = ? AND a.UserNo = ?'); // Prepare the SQL query.
    $sth->bindParam(1, $_GET["HostName"], PDO::PARAM_STR); // Bind the parameter to the query.
    $sth->bindParam(2, $_SESSION["id"], PDO::PARAM_STR); // Bind the parameter to the query.
    $sth->execute(); // Execute the query.
    if($sth->rowCount() == 0) { // If the query returned no results.
        header("Location: home.php?noperms"); // Redirect to login.php page
        die(); // Stop further execution.
    }
    $result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result.

} else { // If the user is an admin,
    $sth = $conn->prepare('SELECT * FROM SmartBox WHERE HostName = ?'); // Prepare the SQL query.
    $sth->bindParam(1, $_GET["HostName"], PDO::PARAM_STR); // Bind the parameter to the query.
    $sth->execute(); // Execute the query.
    if($sth->rowCount() == 0) { // If the query returned no results.
        header("Location: home.php?noresults"); // Redirect to login.php page
        die(); // Stop further execution.
    }
    $result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result.
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
      <div class="row">
        <div class="col s12" style="margin-bottom: 40px">
          <h1 class="header center-on-small-only">Welcome, <?= $_SESSION["user"] ?></h1>
          <h4 class="light text-lighten-4 center-on-small-only">Editing <strong><?= htmlentities($_GET["HostName"]) ?></strong></h4>
        </div>
      </div>
      <div class="row">
      
      <table id="smartboxes">
        <thead>
          <tr>
              <th>HostName</th>
              <th>Description</th>
              <th>Location</th>
          </tr>
          <?php
            echo "<tr>"; // Start a new row.
            echo "<td>"; // Start a new column.
            echo $result["HostName"]; // Display the HostName.
            echo "</td>"; // End the column.
            echo "<td>"; // Start a new column.
            echo $result["Description"]; // Display the Description.
            echo "</td>"; // End the column.
            echo "<td>"; // Start a new column.
            echo $result["Location"]; // Display the Location.
            echo "</td>"; // End the column.
            echo "</tr>"; // End the row.
          ?>
        </thead>

        <tbody>
        </tbody>
      </table>
      <br>
      <hr />
      <br>

      </div>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   </body>
   <script>
     document.addEventListener('DOMContentLoaded', function() { // When the page has loaded.
        var elems = document.querySelectorAll('select'); // Get all the select elements.
    });

  // Or with jQuery

  $(document).ready(function(){ // When the page has loaded.
    $('select').formSelect(); // Initialise the select elements.
    $( "select" ).change(function() { // When a select element is changed.
        const selected = this.value; // Get the value of the selected option.
    });
  });

  $("#genConfig").on("click", () => { // When the generate config button is clicked.
    const selects = $("select"); // Get all the select elements.
    for(let select of selects) { // For each select element.
        console.log($(select).val()); // Log the value of the select element.
    }
  });

   </script>
</html>
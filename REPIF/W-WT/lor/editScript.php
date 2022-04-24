<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"])) { // Check if a user is logged in.
    header("Location: index.php"); // If not, redirect to the login page.
    die(); // Stop the script.
}

if(!isset($_GET["ScriptName"])) { // Check if the script name is set. 
    header("Location: home.php?badscript"); // If not, redirect to the home page.
    die(); // Stop the script.
}
require("db.php"); // Connect to the database. 

if(isset($_POST["sname"], $_POST["spath"], $_POST["sdesc"], $_GET["ScriptName"])) {   // Check if the script name, path, and description have been set.
    $sth2 = $conn->prepare('UPDATE Script SET ScriptName=?, Path=?, Description=? WHERE ScriptName = ?'); // Prepare the statement.
    $sth2->bindParam(1, $_POST["sname"], PDO::PARAM_STR); // Bind the script name.
    $sth2->bindParam(2, $_POST["spath"], PDO::PARAM_STR); // Bind the script path.
    $sth2->bindParam(3, $_POST["sdesc"], PDO::PARAM_STR); // Bind the script description.
    $sth2->bindParam(4, $_GET["ScriptName"], PDO::PARAM_STR); // Bind the script name.
    $sth2->execute(); // Execute the statement.
    header("Location: managescripts.php?updated"); // Redirect to the manage scripts page.
    exit(); // Stop the script.
}

$result = null; // Initialize the result variable.
if($_SESSION["admin"] == false) { // Check if the user is an admin.

    $sth = $conn->prepare('SELECT a.HostName, b.Description, b.Location, b.UserNo FROM SmartBoxAccess a LEFT JOIN SmartBox b ON a.HostName = b.HostName WHERE a.HostName = ? AND a.UserNo = ?'); // Prepare the statement.
    $sth->bindParam(1, $_GET["HostName"], PDO::PARAM_STR); // Bind the host name.
    $sth->bindParam(2, $_SESSION["id"], PDO::PARAM_STR); // Bind the user ID.

    $sth->execute(); // Execute the statement.
    if($sth->rowCount() == 0) { // Check if the user has access to the host.
        header("Location: home.php?noperms"); // If not, redirect to the home page.
        die(); // Stop the script.
    }
    $result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch the result.
} else { // If the user is an admin.
    $sth = $conn->prepare('SELECT * FROM Script WHERE ScriptName = ?'); // Prepare the statement. 
    $sth->bindParam(1, $_GET["ScriptName"], PDO::PARAM_STR); // Bind the script name.
    $sth->execute(); // Execute the statement.
    if($sth->rowCount() == 0) { // Check if the script exists. 
        header("Location: home.php?noresults"); // If not, redirect to the home page.
        die(); // Stop the script.
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
                if($_SESSION["admin"] == true) { // Check if the user is an admin:
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
          <h4 class="light text-lighten-4 center-on-small-only">Editing <strong><?= htmlentities($_GET["ScriptName"]) ?></strong></h4>
        </div>
      </div>
      <div class="row">
      
      <table id="smartboxes">
        <thead>
          <tr>
              <th>ScriptName</th>
              <th>Path</th>
              <th>Description</th>
          </tr>
          <?php
            echo "<tr>"; // Start the table row.
            echo "<td>"; // Start the table data.
            echo $result["ScriptName"]; // Display the script name.
            echo "</td>"; // End the table data.
            echo "<td>"; // Start the table data.
            echo $result["Path"]; // Display the script path.
            echo "</td>"; // End the table data.
            echo "<td>"; // Start the table data.
            echo $result["Description"]; // Display the script description.
            echo "</td>"; // End the table data.
            echo "</tr>"; // End the table row.
          ?>
        </thead>

        <tbody>
        </tbody>
      </table>
      <br>
      <hr />
      <br>
      <div class="row">
        <form class="col s12" method="post">
            <div class="row">
                <div class="input-field col s12">
                <input id="sname" type="text" class="validate" name="sname" value="<?= $result["ScriptName"] ?>">
                <label for="sname">Script Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                <input id="spath" type="text" class="validate" name="spath" value="<?= $result["Path"] ?>">
                <label for="spath">Path</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                <input id="sdesc" type="text" class="validate" name="sdesc" value="<?= $result["Description"] ?>">
                <label for="sdesc">Description</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="submit" class="waves-effect waves-light btn" value="Edit">
                </div>
            </div>
        </form>
    </div>

    <div class="row center-align">
        <div class="col s4">
          <h5>
            <div class="input-field col s12">
              <select id="boxSelect">
              </select>
              <label>Select Group</label>
            </div>
            <a class="waves-effect waves-light btn" id="addBox">Add Group</a>
          </h5>
        </div>
        <div class="col s4">
        </div>
        <div class="col s4">
          <h5>
            <div class="input-field col s12">
              <select id="boxRemove">
              </select>
              <label>Remove Group</label>
            </div>
            <a class="waves-effect waves-light btn" id="removeBox">Remove Group</a>
          </h5>
        </div>
      </div>

      </div>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   </body>
   <script>

  $(document).ready(function(){ // When the document is ready...
    $('select').formSelect(); // Initialize select form.
    $( "select" ).change(function() { // When the select is changed...
        const selected = this.value; // Get the selected value.
    });
  });

  $("#addBox").on("click", () => { // When the add button is clicked...
    const value = $("#boxSelect").val(); // Get the selected value.
    $.get(`scripts.php?ScriptName=<?= $_GET["ScriptName"] ?>&GroupNo=${value}`, function() { // Send the selected value to the server.
        refreshRemove(); // Refresh the remove select.
    });
  });

  $("#removeBox").on("click", () => { // When the remove button is clicked...
    const value = $("#boxRemove").val(); // Get the selected value.
    $.get(`scripts.php?ScriptNameRemove=<?= $_GET["ScriptName"] ?>&HostName=${value}`, function() { // Send the selected value to the server.
        refreshRemove(); // Refresh the remove select.
    });
  });

  function refreshRemove() { // Refresh the remove select.
    $('#boxRemove').empty(); // Empty the select.
    $.getJSON("scripts.php?ScriptName=<?= $_GET["ScriptName"] ?>", function (data) { // Get the data from the server.
      $.each(data, function (key, entry) { // For each entry in the data...
        $("#boxRemove").append($('<option></option>').attr('value', entry.HostName).text(`${entry.HostName} - Group #${entry.GroupNo}`)); // Add the entry to the select.
      })
      $('#boxRemove').formSelect(); // Initialize the select.
    });
  }

  $(document).ready(function () { // When the document is ready...
    $.getJSON("groups.php", function (data) { // Get the data from the server.
      $.each(data, function (key, entry) { // For each entry in the data...
        $("#boxSelect").append($('<option></option>').attr('value', entry.GroupNo).text(`Group #${entry.GroupNo}`)); // Add the entry to the select.
      })
      refreshRemove(); // Refresh the remove select.
      $('#boxSelect').formSelect(); // Initialize the select.
    });

    $.getJSON("scripts.php?ScriptName=<?= $_GET["ScriptName"] ?>", function (data) { // Get the data from the server.
      $.each(data, function (key, entry) { // For each entry in the data...
        $("#boxRemove").append($('<option></option>').attr('value', entry.HostName).text(`${entry.HostName} - Group #${entry.GroupNo}`)); // Add the entry to the select.
      })
      $('#boxRemove').formSelect(); // Initialize the select.
    });
  });

   </script>
</html>
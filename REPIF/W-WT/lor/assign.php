<?php
session_start(); // Start the session.
if(!isset($_SESSION["user"]) || $_SESSION["admin"] == false) { // If session variable "user" does not exist.
    header("Location: index.php"); // Re-direct to index.php
    die(); // Die
}

if(!isset($_GET["HostName"])) { // If the HostName variable is not set.
    header("Location: home.php?badselect"); // Re-direct to home.php with the badselect parameter.
    die(); // Die
}
require("db.php"); // Include the database connection.

$sth = $conn->prepare('SELECT * FROM SmartBox WHERE HostName = ?'); // Prepare the SQL statement.
$sth->bindParam(1, $_GET["HostName"], PDO::PARAM_STR);  // Bind the HostName variable to the SQL statement.
$sth->execute(); // Execute the SQL statement.
if($sth->rowCount() == 0) { // If the SQL statement did not return any rows.
    header("Location: home.php?noBox"); // Re-direct to home.php with the noBox parameter.
    die(); // Die
}
$result = $sth->fetch(PDO::FETCH_BOTH); // Fetch the SQL statement.
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
    <div class="row">
      <div class="col s12" style="margin-bottom: 40px">
        <h1 class="header center-on-small-only">Welcome, <?= $_SESSION["user"] ?></h1>
        <h4 class="light text-lighten-4 center-on-small-only">Assigning
          <strong><?= htmlentities($_GET["HostName"]) /* Security */ ?></strong></h4>
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
            echo "<tr>"; // Start the table row.
            echo "<td>"; // Start the table data.
            echo $result["HostName"]; // Display the HostName.
            echo "</td>"; // End the table data.
            echo "<td>"; // Start the table data.
            echo $result["Description"]; // Display the Description.
            echo "</td>"; // End the table data.
            echo "<td>"; // Start the table data.
            echo $result["Location"]; // Display the Location.
            echo "</td>"; // End the table data.
            echo "</tr>";   // End the table row.
          ?>
        </thead>

        <tbody>
        </tbody>
      </table>
      <br>
      <hr />
      <br>
      <div class="row center-align">
        <div class="col s4">
          <h5>
            <div class="input-field col s12">
              <select id="userSelect">
              </select>
              <label>Select User</label>
            </div>
            <a class="waves-effect waves-light btn" id="assignUser">Add User</a>
          </h5>
        </div>
        <div class="col s4">
        </div>
        <div class="col s4">
          <h5>
            <div class="input-field col s12">
              <select id="userSelectRemove">
              </select>
              <label>Select User</label>
            </div>
            <a class="waves-effect waves-light btn" id="removeUser">Remove User</a>
          </h5>
        </div>
      </div>

    </div>


  </div>
  <!--JavaScript at end of body for optimized loading-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
<script>
  $(document).ready(function () { // When the document is ready.
    $.getJSON("users.php", function (data) { // Get the JSON data.
      $.each(data, function (key, entry) { // For each entry in the JSON data.
        select.append($('<option></option>').attr('value', entry.UserNo).text(entry.Name)); // Append the option to the select.
      })
      $('#userSelect').formSelect(); // Set up the select.
    });

    $.getJSON("users.php?hostname=<?= $_GET["HostName"] ?>", function (data) { // Get the JSON data.
        $.each(data, function (key, entry) { // For each entry in the JSON data.
          select2.append($('<option></option>').attr('value', entry.UserNo).text(entry.Name)); // Append the option to the select.
        })
        if (document.getElementById('userSelectRemove').options.length == 0) { // If there are no options in the select.
          select2.append($('<option></option>').attr('value', "").text("No users assigned").attr('disabled',
            true)); // Append the option to the select.
        }
        $('#userSelectRemove').formSelect(); // Set up the select.
      });

    $("#assignUser").on("click", () => { // When the assignUser button is clicked.
      const selected = $("#userSelect").val(); // Get the selected value.
      $.post("users.php", { // Post the data to the users.php file.
        "HostName": "<?= $_GET["HostName"] ?>", // The HostName.
        "UserNo": selected // The UserNo.
      }, function () { // When the post is complete.
        M.toast({
          html: 'The user has been assigned to the SmartBox' // Display a toast.
        })
        refreshRemove(); // Refresh the remove select.
      });
    })

    $("#removeUser").on("click", () => { // remove user
      const selected = $("#assignUser").val(); // Get the selected value.
      $.post("users.php", { // Post the data to the users.php file.
        "HostName": "<?= $_GET["HostName"] ?>", // The HostName. 
        "UserNo": $("#userSelectRemove").val(), // The UserNo.
        "remove": true // The remove flag.
      }, function () { // When the post is complete.
        $(select2).find('option:selected').remove(); // Remove the selected option.
        M.toast({ // Display a toast.
          html: 'The user has been removed from the SmartBox'
        })
        refreshRemove(); // Refresh the remove select.
      });
    })
  });

  function refreshRemove() {
    $('#userSelectRemove') // Get the select.
      .find('option') // Get all the options.
      .remove() // Remove all the options.
      .end() // Go back to the select.
      .append('<option value="" disabled selected>Select a user</option>'); // Add the default option.
    $.getJSON("users.php?hostname=<?= $_GET["HostName"] ?>", function (data) { // Get the JSON data.
        $.each(data, function (key, entry) { // For each entry in the JSON data.
          select2.append($('<option></option>').attr('value', entry.UserNo).text(entry.Name)); // Append the option to the select.
        })
        if (document.getElementById('userSelectRemove').options.length == 0) { // If there are no options in the select.
          select2.append($('<option></option>').attr('value', "").text("No users assigned").attr('disabled',
            true)); // Append the option to the select.
        }
        $('#userSelectRemove').formSelect(); // Set up the select.
    });
  }

  // Declare constants.
  const select = $("#userSelect"); // Get the select.
  const select2 = $("#userSelectRemove"); // Get the select.
</script>

</html>
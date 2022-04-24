<?php
session_start(); // Start the session.
if(isset($_SESSION["user"])) { // Check if a user is logged in.
    header("Location: home.php"); // Redirect the user to the home page.
    die(); // Die to end the script.
}

if(isset($_POST["username"], $_POST["password"], $_POST["fname"], $_POST["lname"], $_POST["email"])) { // Check if the form has been submitted.
    if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"])) { 
      require("db.php"); // Connect to the database.
      $sth = $conn->prepare('INSERT INTO user (Name, FirstName, LastName, Technician, Email, Passwd) VALUES (?, ?, ?, False, ?, ?)'); // Prepare the SQL statement.
      $sth->bindParam(1, $_POST["username"], PDO::PARAM_STR); // Bind the username to the SQL statement.
      $sth->bindParam(2, $_POST["fname"], PDO::PARAM_STR); // Bind the first name to the SQL statement.
      $sth->bindParam(3, $_POST["lname"], PDO::PARAM_STR); // Bind the last name to the SQL statement.
      $sth->bindParam(4, $_POST["email"], PDO::PARAM_STR); // Bind the email to the SQL statement.
      $pwd = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password.
      $sth->bindParam(5, $pwd, PDO::PARAM_STR); // Bind the hashed password to the SQL statement.
      $sth->execute(); // Execute the SQL statement.
      header("Location: index.php?registered"); // Redirect the user to the home page.
      die(); // Die to end the script.
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
   </head>
   <body>
      <nav>
         <div class="nav-wrapper">
            <a href="#" class="brand-logo">REPIF</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
               <li><a href="index.php">Login</a></li>
            </ul>
         </div>
      </nav>
      <div class="container">
         <!-- Page Content goes here -->
         <div class="row">
            <div class="col s6 offset-s3">
               <div class="row">
                  <div class="col s12">
                     <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                           <span class="card-title">Register</span>
                           <div class="row">
                              <form class="col s12" method="post">
                                 <div class="row">
                                    <div class="input-field col s12">
                                       <input id="Username" type="text" class="validate" name="username">
                                       <label for="Username">Username</label>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="input-field col s12">
                                       <input id="password" type="password" class="validate" name="password">
                                       <label for="password">Password</label>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="input-field col s12">
                                       <input id="fname" type="text" class="validate" name="fname">
                                       <label for="fname">First Name</label>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="input-field col s12">
                                       <input id="lname" type="text" class="validate" name="lname">
                                       <label for="lname">Last Name</label>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="input-field col s12">
                                       <input id="email" type="email" class="validate" name="email">
                                       <label for="email">Email</label>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <input class="waves-effect waves-light btn" type="submit" value="Register"></input>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--JavaScript at end of body for optimized loading-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   </body>
</html>


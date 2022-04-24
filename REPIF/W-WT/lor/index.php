<?php
session_start(); // Start the session.
if(isset($_SESSION["user"])) { // Check if a user is logged in.
    header("Location: home.php"); // If they are, redirect to the home page.
    die(); // Die to stop the script.
}

if(isset($_POST["username"], $_POST["password"])) { // Check if username and password are set
    if(!empty($_POST["username"]) && !empty($_POST["password"])) { // Check if username and password are not empty
        require("db.php"); // Require database connection
        $sth = $conn->prepare('SELECT * FROM user WHERE Name = ?');  // Prepare statement
        $sth->bindParam(1, $_POST["username"], PDO::PARAM_STR); // Bind username
        $sth->execute(); // Execute statement
        if($sth->rowCount() == 0) { // Check if username is not in database
            header("Location: index.php?badlogin"); // Redirect to index.php with badlogin
            die(); // Die
        } else { // Username is in database
            $result = $sth->fetch(PDO::FETCH_ASSOC); // Fetch result 
            if(password_verify($_POST["password"], $result["Passwd"])) { // Check if password is correct
                $_SESSION["user"] = $_POST["username"]; // Set session user
                $_SESSION["id"] = $result["UserNo"]; // Set session id
                $_SESSION["admin"] = $result["Technician"]; // Set session admin
                header("Location: home.php"); // Redirect to home.php
                die(); // Die
            } else { // If password is incorrect
                header("Location: index.php?badlogin"); // Redirect to index.php with badlogin
                die(); // Die
            }
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
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   </head>
   <body>
      <nav>
         <div class="nav-wrapper">
            <a href="#" class="brand-logo">REPIF</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
               <li><a href="register.php">Register</a></li>
            </ul>
         </div>
      </nav>
      <div class="container">
         <!-- Page Content goes here -->
         <div class="row">
            <div class="col s6 offset-s3">
            <?php
            if(isset($_GET["registered"])) { // Check if registered is set
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Registered</span>
                            <p>Your account has been created
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

            <?php
            if(isset($_GET["badlogin"])) { // Check if badlogin is set
            ?>
            <div class="row">
                <div class="col s12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Error</span>
                            <p>Wrong login</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>


               <div class="row">
                  <div class="col s12">
                     <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                           <span class="card-title">Login</span>
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
                                    <input class="waves-effect waves-light btn" type="submit" value="Login"></input>
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


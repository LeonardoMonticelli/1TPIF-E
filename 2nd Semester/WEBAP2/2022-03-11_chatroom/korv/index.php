<?php
session_start();
if(isset($_SESSION["username"])) {
  header("Location: chat.php"); // Redirect to chat.php
  exit(); // ...
}
if(isset($_POST["username"])) {
  $_SESSION["username"] = $_POST["username"];
}
?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <form method="post">
    <p>Username: </p> <input name="username">
      <input type="submit">
    </form>
  </body>
</html>
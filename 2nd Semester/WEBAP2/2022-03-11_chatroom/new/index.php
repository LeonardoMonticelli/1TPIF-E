<?php
  session_start();
  
  include_once "head.php";

  if(isset($_SESSION["username"])) {
    header("Location: chatroom.php");
    exit();
  }

  if(isset($_POST["username"])) {
    $_SESSION["username"] = $_POST["username"];
    header("Location: chatroom.php");
    exit();
  }
?>

  <head>

    <h1 class='fw-bold'>Login</h1>

  </head>
  <body>

    <form method="post">

    <div class="form-group m-3">
      <form method="post">

          <label>Username</label>
          <input name="username">
          <input type="submit" value="Log in">

      </form>
    </div>

    </form>

  </body>
</html>
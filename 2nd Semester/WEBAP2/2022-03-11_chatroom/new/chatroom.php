<?php
  session_start();

  $pageTitle ="Chatroom";
  include_once "head.php";

  if(!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit(); 
  }

  if(isset($_POST["logout"])){
    unset($_SESSION["username"]);
    header("Location:index.php");
    exit();
  }
?>

  <form action="" method="post">
    <button name="logout">Logout</button>

  </form>

  <h1>Messages:</h1>

  <table id="chatBox">
    
    <tr>
      <th>Username</th>
      <th>Message</th>
    </tr>

  </table>

  <input id="message">
  <button id="sendMessage">Send</button>
  
  <script src="script.js"></script>
</html>
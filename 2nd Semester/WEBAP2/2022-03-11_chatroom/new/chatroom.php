<?php
session_start();

if(!isset($_SESSION["username"])) {
  header("Location: index.php");
  exit(); 
}
?>

<html>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>

  <a href="logout.php">Logout</a>

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
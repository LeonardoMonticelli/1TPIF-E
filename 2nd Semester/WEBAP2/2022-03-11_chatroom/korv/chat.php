<?php
session_start();

if(!isset($_SESSION["username"])) {
  header("Location: index.php"); // redirect to index
  exit(); // ...
}
?>

<html>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
  <style>
    table, th, td {
      border: 1px solid black;
    }
  </style>
  <h1>Messages:</h1>
  <table id="messagetable">
    <tr>
      <th>Username</th>
      <th>Message</th>
    </tr>
  </table>
  <input id="message">
  <button id="sendMessage">Send</button>
  <script src="chat.js"></script>
</html>
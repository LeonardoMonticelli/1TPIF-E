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

<style>
  .chonk { width: 300px;;}
  table tbody { height:300px; overflow-y:scroll; display:block; }
  table thead { display:block; }
</style>

  <form action="" method="post">
    <button class="btn btn-danger" name="logout">Logout</button>
  </form>

  <h1>Chatroom:</h1>

    <div class="chonk">
      <table class="table table-borderless table-sm" id="chatBox">
          <tbody>
          </tbody>
      </table>

      <div class="input-group mb-3">
        <input id="message" type="text" class="form-control" placeholder="Type here!" aria-label="Username" aria-describedby="basic-addon1">
        <button class="btn btn-outline-secondary" type="button"  id="sendMessage" >Send</button>
      </div>
    </div>

  <div>pls scroll after you type I havent figured that one out</div>
  
  <script src="script.js"></script>
</html>
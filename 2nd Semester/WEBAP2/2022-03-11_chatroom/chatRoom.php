<?php //head
    $pageTitle ="Welcome to the chatroom";
    include_once "head.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";

    var_dump($_SESSION["isUserLoggedIn"]);

    if(isset($_POST["username"])){
        $_SESSION["isUserLoggedIn"] = true;
    }
?>
<body>
    <a class="text-decoration-none text-light p-1" href="logout.php">Logout</a>
    <h1>Welcome to the chatroom.</h1>
    <input type="textbox" id="msgContent">
    <input id="myUser" type="hidden" value='<?= $_POST["username"]?>'>
    <button id="send">Send</button>
</body>
</html>
<?php //head
    $pageTitle ="Chatroom";
    include_once "head.php";

    if($_SESSION["isUserLoggedIn"] = false) {
        header("Location: index.php");
        exit();
    }
?>
<body>
    <a class="text-decoration-none p-1" href="logout.php">Logout</a>
    <h1>Welcome to the chatroom.</h1>

    <h1>Messages:</h1>

    <table id="chatTable">
    <tr>
        <th>Username</th>
        <th>Message</th>
    </tr>
    </table>

    <input type="textbox" id="msgContent">
    <button id="send">Send</button>

    <script src="script.js"></script>
</body>
</html>
<?php
    var_dump($_SESSION["isUserLoggedIn"]);
?>
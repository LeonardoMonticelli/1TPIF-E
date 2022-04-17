<?php //head
    $pageTitle ="Chatroom";
    include_once "head.php";

    if(!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    }
?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<body>
    <a class="text-decoration-none p-1" href="logout.php">Logout</a>

    <h1>Welcome to the chatroom.</h1>

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

</body>
</html>
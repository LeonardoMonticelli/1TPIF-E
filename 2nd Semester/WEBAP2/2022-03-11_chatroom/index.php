<?php //head
    $pageTitle ="Please log in";
    include_once "head.php";

    if(isset($_SESSION["username"])) {
        header("Location: chatRoom.php");
        exit();
    }

    if(isset($_POST["username"])) {
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["isUserLoggedIn"] == true;
    }
?>
<body>
    <h1>
        Please log in to access the chatroom:
    </h1>

    <form method="POST" action="chatRoom.php">
        Please type-in your username:
        <input type="" name="username">
        <input type="submit" value="Enter">
    </form>
</body>
</html>
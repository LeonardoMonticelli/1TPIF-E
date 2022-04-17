<?php //head

    $pageTitle ="Log in";

    include_once "head.php";

    if(isset($_SESSION["username"])) {
        header("Location: chatRoom.php");
        exit();
    }

    if(isset($_POST["username"])) {
        $_SESSION["username"] = $_POST["username"];
        header("Location: chatRoom.php");
        exit();
    }
?>
<body>
    <h1>
        Please log in to access the chatroom:
    </h1>

    <form method="POST">
        <div>Please type-in your username:</div>
        <input name="username">
        <input type="submit" value="Enter">
    </form>
</body>
</html>
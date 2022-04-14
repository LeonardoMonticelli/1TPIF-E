<?php //head
    $pageTitle ="Log in";
    include_once "head.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
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

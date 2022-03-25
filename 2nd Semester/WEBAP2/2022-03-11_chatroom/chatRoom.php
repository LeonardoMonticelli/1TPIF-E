<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Chat Enter</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>

    <!-- Insert JSON -->
</head>
<body>
    <h1>Welcome to the chatroom.</h1>
    <input type="textbox" id="msg">
    <input id="myUser" type="hidden" value='<?= $_POST["userName"]?>'>
    <button id="sendMsg">Send</button>
</body>
</html>
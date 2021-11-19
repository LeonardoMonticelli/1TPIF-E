<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Order flowers</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='.css'>
    <script src='.js'></script>
</head>
<body>
    <form action="ordered.php" method="post">
        <select name="flowers" id="">
            <option value="red">Red</option>
            <option value="yellow">Yellow</option>
        </select>
        <div>Count: <input type="number" placeholder="0"></div>
        <input type="submit" value="Order">
    </form>
    <?php
        if(isset($_GET["count"])&&isset($_GET["count"])){
            
        }
        file_put_contents("data.txt", "", FILE_APPEND | LOCK_EX);
    ?>
</body>
</html>
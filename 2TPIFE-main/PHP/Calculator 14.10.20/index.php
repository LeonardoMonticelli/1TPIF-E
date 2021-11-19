<?php 
    if(isset($_POST['equal'])) {
        $num1 = $_POST['var1'];  
        $num2 = $_POST['var2'];

        if(!is_numeric($num1) || !is_numeric($num2)) die("haks");

        switch ($_POST["operator"]) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                $result = $num1 / $num2;
                break;
            default:
              $result = 0;
          }   
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <form action="" method="post" autocomplete="off">
        <input type="number" name="var1">
        <select type="text" name="operator">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="number" name="var2">
        <input type="submit" name="equal" value="=">
        <?= (isset($result)) ? $result : null ?>
    </form>
</body>

</html>
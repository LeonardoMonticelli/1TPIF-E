<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>TEST 27.01.21 - EX2</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <img src="SumFormula.JPG">
    <form action="" method="post">
        <select name="list" id="">
            <option value="1">Expand formula</option>
            <option value="2">Compute result</option>
            <option value="3">Expand and compute</option>
        </select>
        Enter the value for Start:<input type="text" name="start" id="">
        Enter the value for n:<input type="text" name="n" id="">
        <input type="submit" value="just DO IT">
    </form>
    <?php
        $i=$_POST['start'];
        $n=$_POST['n'];
        if(isset($i)&&isset($n)){
            echo("($i-2)*($i+3)+($n-2)*($n+3)<br>");
            echo("The computed sum=".($i-2)*($i+3)+($n-2)*($n+3)."<br>");
        }
    ?>
</body>
</html>
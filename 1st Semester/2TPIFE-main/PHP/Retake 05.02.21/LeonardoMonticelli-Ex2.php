<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ex2</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php
        if(isset($_POST["n"])&&isset($_POST["start"])){
            if($_POST["start"]<$_POST["n"]-1){
                if($_POST["list"]=="1"){
                    for($b=0;$b<$_POST["n"];$b++){
                        $result+=($_POST["start"].-2)*($_POST["start"]+3);
                    }
                    echo("=".$result);
                }
                elseif($_POST["list"]=="2"){
                    echo("in progress");
                }
            }
        } else {
            ?>
                <img src="SumFormula.JPG" alt="SumFormula">
                <form action="" method="post">
                    <select name="list" id="">
                        <option value="1">Display and compute sum</option>
                        <option value="2">Display reversed sum and compute it</option>
                    </select>
                    Enter the value for n:<input type="text" name="n" id="">
                    Enter the value for Start:<input type="text" name="start" id="">
                    <input type="submit" value="DO">
                </form>
            <?php
        }
    ?>
</body>
</html>
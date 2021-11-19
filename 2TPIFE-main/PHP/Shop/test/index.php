<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>test</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
        .red{
            background-color: red;
            width: 100px;
            height: 100px;
        }
        .blue{
            background-color: blue;
            width: 100px;
            height: 100px;
        }
        .yellow{
            background-color: yellow;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <?php
        function selectCheck($checkValue){
            if(isset($_POST["box"]) && ($_POST["box"]==$checkValue))
            print "selected";
        }
        function displayBox(){
            if(isset($_POST["box"])){
                for($a=0;$a<$_POST["numberOfBoxes"];$a++){
                    ?><div class="<?=$_POST['box']?>"></div><?php
                }
            }
        }
    ?>
    <form action="" method="post">
        <select name="box">
            <option value="red" <?php selectCheck("red");?> >red box</option>
            <option value="blue" <?php selectCheck("blue");?>>blue box</option>
            <option value="yellow" <?php selectCheck("yellow");?>>yellow box</option>
        </select>
        <input type="submit" value="Create">
        <input type="text" name="numberOfBoxes">
        <?php displayBox()?>
    </form>
</body>
</html>

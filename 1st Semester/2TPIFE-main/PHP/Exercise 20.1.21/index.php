<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Exercises</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
<style>
    .box {
        height: 10px;
        width: 10px;
    }
    .red{
        background-color: red;
    }
    .blue{
        background-color: blue;
    }
    .yellow{
        background-color: rgb(243, 243, 70);
    }
</style>
</head>
<body>  
    <form action="" method="post">
        <input type="submit" value="Generate" name="gen">
    </form>
    <?php
        if(isset($_POST["gen"])){
            $fileReader = fopen("data.txt","r");
            $newArr= [];
            while($line=fgets($fileReader)){
                $sep= explode(" ", $line);
                array_push($newArr,$sep);
                $number= $sep[0];
                $colour= $sep[1];
                for($a=0;$a<$number;$a++){
                    ?> <div class="box <?=$colour?>"></div></br>
                    <?php }
                // var_dump($newArr);
            }
        }
    ?>   
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>exercise</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>

    <?php
        // $fileReader = fopen("data.txt","r");
        // $numbersArr = [];
        // $sum=0;
        // while($number = trim(fgets($fileReader))){
        //     // $sum=$sum+$number;
        //     array_push($numbersArr, $number);
        //     // echo($numbersAr."<br>");
        // }
        //     echo("the sum of the numbers is ".array_sum($numbersArr));
        //     // echo("the sum of the numbers is ".$sum);
    ?>
    <form action="" method="post">
        <input type="text" name="inputN">
        <input type="submit" value="Search">
    </form>
    <?php
        if(isset($_POST["inputN"])){
            echo("your mom ");
            $fileReader = fopen("data.txt","r");
            $timesOfN=0;
            while($number = trim(fgets($fileReader))){
                if($_POST["inputN"]==$number){
                    $timesOfN=$timesOfN+1;
                }
            }
            echo($_POST["inputN"]." has been found ".$timesOfN." times");
        }
    ?>
</body>
</html>
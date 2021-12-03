<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
    <!-- How many ducks <input type="text" name="duck"><button>GO</button> -->
    <!-- <div></div> -->
    <?php
        if(isset($_GET["duck"])){
            for($i=0; $i < $_GET["duck"]; $i++){
                ?>
                    <img src="hampter.png">
                <?php
            }
        }
        
        // if(isset($_GET["chicken"])){
        //     for($i=0; $i < $_GET["chicken"]; $i++){
                ?>
                    <!-- <img src="chicken.jpg"> -->
                <?php
        //     }
        // }
    ?>
</body>
</html>
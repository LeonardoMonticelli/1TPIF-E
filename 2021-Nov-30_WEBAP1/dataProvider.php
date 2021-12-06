<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
</head>
<body>
    <?php
        if(isset($_GET["duck"])){
           for($i=0; $i < $_GET["duck"]; $i++){
                ?>
                    <img src="duck.jpg">
                <?php
            } 
        }
        if(isset($_GET["chicken"])){            
            for($i=0; $i < $_GET["chicken"]; $i++){
                ?>
                    <img src="chicken.jpg">
                <?php
            }
        }
        
    ?>
</body>
</html>
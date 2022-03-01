<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src='main.js'></script>
</head>
<body>
    <?php
    
        if(isset($_GET['word'])){
            $text= $_GET['word'];
            $count=0;
            $searchChar="b";
            for($i=0;$i<strlen($text);$i++){
                $str = explode(" ",$text);
                if($str[$i]==$searchChar){
                    $count++;
                }
            }            
        }
    ?>

    <input type="text" id="word">
    <button id="count">Count</button>
    <div id="display"></div>
</body>
</html>
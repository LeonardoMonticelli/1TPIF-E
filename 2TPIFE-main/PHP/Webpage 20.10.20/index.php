<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>WEbpage</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='.css'>
    <script src='.js'></script>

    <style>
        .box {
            height: 5px;
            width: 5px;        
            display: inline-block;
        }
        .red{
            background-color: red;
        }
        .purple {
            background-color: purple;
        }
        .blue{
            background-color: blue;
        }
        .yellow{
            background-color: yellow;
        }
    </style>
</head>
<body>
    <div>Box: </div>
    <form action="" method="post" autocomplete="off">
            <select type="text" name="color">
                <option value="red" <?= (isset($_POST["color"]) && $_POST["color"] == "red") ? "selected" : ""; ?>>red</option>
                <option value="blue" <?= (isset($_POST["color"]) && $_POST["color"] == "blue") ? "selected" : ""; ?>>blue</option>
                <option value="yellow" <?= (isset($_POST["color"]) && $_POST["color"] == "yellow") ? "selected" : ""; ?>>yellow</option>
            </select>
            <input type="number" name="amount" placeholder="<?= (isset($_POST["amount"])) ? $_POST["amount"] : "";?>">
            <input type="submit" name="display" value="Display">
    </form>
    <div id="container">
        <?php
        if(isset($_POST["display"]) && isset($_POST["amount"])){
            $amount = $_POST["amount"];
            $color = $_POST["color"];
            for($a=0; $a<$amount; ++$a){
                ?>
                <div class="box <?=$color?>"></div>
                <?php
            }
        }
        ?>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Car Shop</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='loadCars.js'></script>

    <style>
        img {
            height: 175px;
            width: 257px;
        }
    </style>
</head>
<body>
    Type in a 
    <select name="" id="choiceOfPrice">
        <option value="0">Max</option>
        <option value="1">Min</option>
    </select>
     price: <input type="text" id="givenPrice"><button>Filter</button>
    <table>

    </table>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <style>
        img{
            width:200px; 
        }
        .greenBack{
            background-color:green;
        }
        .yellowBack{
            background-color:yellow;
        }
        .blueBack{
            background-color:blue;
        }

        .OneProduct{
            width:250px;
            text-align:center;
            margin:10px;
        }
        .AllProducts{
            display:flex;
            flex-wrap:wrap;
            justify-content:space-around;
        }  
    </style>
</head>
<body>
    <h1>Car dealership/rental of 2TPIF </h1>
    <div class="AllProducts">
        <div class="OneProduct greenBack">
            <img src="Dacia.jpg"><BR>
            Price: 10000 EUR<BR>
            In stock: 2 cars
        </div>
        <div class="OneProduct yellowBack">
            <img src="Mercedes.jpg"><BR>
            Price: 50000 EUR<BR>
            In stock: 1 cars
        </div>
        <div class="OneProduct blueBack">
            <img src="Ford.jpg"><BR>
            Price: 20000 EUR<BR>
            In stock: 41 cars
        </div>
        <div class="OneProduct blueBack">
            <img src="Ferrari.jpg"><BR>
            Price: 100000 EUR<BR>
            In stock: 2 cars
        </div>
        <div class="OneProduct yellowBack">
            <img src="Renault.jpg"><BR>
            Price: 24000 EUR<BR>
            Out of stock
        </div>
        <div class="OneProduct greenBack">
            <img src="Audi.jpg"><BR>
            Price: 44000 EUR<BR>
            In stock: 3 cars
        </div>
    </div>
</body>
</html>
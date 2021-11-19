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
        <?php
            $productsFile= fopen("products.txt","r");
            while($line=fgets($productsFile)){
                $trimmedLine=trim($line);
                $product = explode(",",$line);
                ?>
                <div class='OneProduct <?=$product[3]?>'>
                    <img src='<?=$product[0]?>'><BR>
                    Price: <?=$product[1]?> EUR<BR>
                    In stock: <?php
                    if($product[2]-$product[4]==0){
                        echo("out of stock");
                    } else {
                        echo($product[2]-$product[4]." cars");
                    }
                    ?> 
                </div>
                <?php
                $totalCars+=$product[2];
                $totalRented+=$product[4];
            }
            $rentedPercent=($totalRented/$totalCars)*100;
            echo("Total number of cars: ".$totalCars."<br>");
            echo("Total number of rented cars: ".$totalRented."<br>");
            echo("Percentage of cars rented: ".$rentedPercent."%<br>");
            fclose($productsFile);
        ?>

    </div>
</body>
</html>
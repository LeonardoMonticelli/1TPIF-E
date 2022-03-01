<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Add products</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>

<body>
<?php
    include_once "navBar.php";
    include_once "dbConnect.php";
    if($_SESSION['role'] != "admin") {
        // header("Location: /");
        die("Unauthorised, you are not an admin");
    } else {
            if(isset($_POST["NewProduct"])){
                $sqlInsert = $connection->prepare("INSERT INTO PRODUCTS(Pr_Name, Pr_Price, Pr_ItemsInStock) values(?,?,?)");
                $sqlInsert->bind_param("sis", $_POST["NewProduct"], $_POST["PriceProduct"], $_POST["StockProduct"]);
                $resultOfExecute = $sqlInsert->execute();
                if(!$resultOfExecute){
                    print "Creation of product, failed.";
                    echo $sql->error;
                } else {
                    echo "Product added succesfully!";
                }
            }  
?>                    
    <form method="POST">
        Name of the product:<input name="NewProduct">
        Price: <input name="PriceProduct">
        Product stock:<input name="StockProduct">
        <input type="submit" value="Add">
    </form>
    
    <?php
    }
    ?>
</body>
</html>
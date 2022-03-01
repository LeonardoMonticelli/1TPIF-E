<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Shopping cart</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php
        include_once "dbConnect.php";

        if(isset($_POST["itemToDelete"])){
            unset($_SESSION["shoppingCart"][$_POST["itemToDelete"]]);
        }

        if(sizeof($_SESSION["shoppingCart"]) == 0) {
            print "Empty basket.";
        }

        if(isset($_POST["buyAll"]) && sizeof($_SESSION["shoppingCart"]) != 0){
            $newOrderStatus = 1;
            $sqlInsert = $connection->prepare("INSERT into ORDERS(NameOFBuyer,OrderItem, HowMany) values(?,?,?);");
            $sqlInsert->bind_param("sii", $_SESSION["currentUser"], $row["OrderItem"] ,$_SESSION["shoppingCart"][$row["ID_Product"]]);
            $insertWentOk = $sqlInsert->execute();
            $newOrderId = mysqli_insert_id($connection);
            $_SESSION["shoppingCart"] = [];
            print "Thank you for your order. It will be processed soon! ";    
        } 

        include_once "navBar.php"
    ?>
    <h1>Shopping cart contents:</h1>
    <table>
        <tr>
            <th>Product name:</th>
            <th>You ordered:</th>
            <th>The price:</th>
        </tr>
        <?php
            // print "We apologize but some of your items have already been ordered..."; // This message will be displayed in the case that the number of tiems ordered exceed the maximum available
            foreach($_SESSION["shoppingCart"] as $key => $value){

                $sqlSelect = $connection->prepare("SELECT * from PRODUCTS where ID_Product=?");
                $sqlSelect->bind_param("i",$key);
                $selectionWentOk = $sqlSelect->execute();
                if($selectionWentOk){
                    $result = $sqlSelect->get_result();
                    $row=$result->fetch_assoc();
                    ?>
                    <tr>
                        <td><?= $row["ProductName"]?></td>
                        <td><?= $value?></td>
                    </tr>
                    <?php
                }
                else{
                    print "Not ok";
                }
            }
        ?>
            <tr>
                <td>
                    <form method="post">
                        <input type="hidden" name="buyAll" value="B">
                        <input type="submit" value="Buy">
                    </form>
                </td>
            </tr> 
    </table>
</body>
</html>
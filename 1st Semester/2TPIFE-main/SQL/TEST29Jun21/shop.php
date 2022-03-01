<?php
    include_once "dbConnect.php";
    if (isset($_POST["addPr"])){
        if(isset($_SESSION["shoppingCart"][$_POST["addPr"]])){
            $_SESSION["shoppingCart"][$_POST["addPr"]] += $_POST["countPr"];
        } else {
            $_SESSION["shoppingCart"][$_POST["addPr"]] = $_POST["countPr"];
        }
    }

    include_once "navBar.php"; 
?>
        <h1>Current amount of products in the database</h1>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product name</th>
                <th>Stock</td>
            </tr>
    
            <?php
                $sqlSelect = $connection->prepare("SELECT ID_Product, ProductName, ItemsAvailable from PRODUCTS");
                $selectExe = $sqlSelect->execute();
                if($selectExe)
                {
                    $result = $sqlSelect->get_result();
                    while($row=$result->fetch_assoc()){
                        if(!isset($_SESSION["shoppingCart"][$row["ID_Product"]]) ||  $_SESSION["shoppingCart"][$row["ID_Product"]] <$row["ItemsAvailable"]){
                        ?>
                        <tr>
                            <td><?=$row["ID_Product"]?></td>
                            <td><?=$row["ProductName"]?></td>
                            <td><?=$row["ItemsAvailable"]?></td>
                            <?php if($_SESSION['userLoggedIn']){

                                ?>
                                <td>
                                    <form method="post">
                                        <input type="hidden" value="<?= $row["ID_Product"]?>" name="addPr">
                                        <input type="number" value=1 name="countPr">
                                        <input type="submit" value="Add">
                                    </form>
                                </td>
                            <?php   }
                                }
                                var_dump($_SESSION["shoppingCart"]);?>
                        </tr>
                        <?php
                    }
                } else {
                    echo "Something went wrong when selecting data";
                }             
            ?>
        </table>
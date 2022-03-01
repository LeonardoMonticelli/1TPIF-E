<?php
    include_once "navBar.php";
    include_once "dbConnect.php";
    if(!$_SESSION['isUserLoggedIn']) {
        // header("Location: /");
        die("Unauthorised, you are not an user");
    } else {?>
        <h1>Current amount of products in the database</h1>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product name</th>
                <th>Product price</th>
                <th>Stock</td>
            </tr>
    
            <?php
                $sqlSelect = $connection->prepare("select Pr_ID, Pr_Name, Pr_Price, Pr_ItemsInStock from PRODUCTS");
                $selectExe = $sqlSelect->execute();
                if($selectExe){
                    $result = $sqlSelect->get_result();
                    while($row=$result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?=$row["Pr_ID"]?></td>
                            <td><?=$row["Pr_Name"]?></td>
                            <td><?=$row["Pr_Price"]?> Euros</td>
                            <td><?=$row["Pr_ItemsInStock"]?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "Something went wrong when selecting data";
                }
            ?>
        </table>
        <?php
    }
?>
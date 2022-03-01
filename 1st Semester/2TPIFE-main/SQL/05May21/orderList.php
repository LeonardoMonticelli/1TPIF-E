<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Order list</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php
        include_once "dbConnect.php";
        include_once "navBar.php";

        // if(!isset($_SESSION["isUserLoggedIn"]) || $_SESSION["role"] == "admin"){
        //     header("location: login.php"); 
        //     die("Access denied");
        // } //This is to prevent for the admin to come in here
    ?>
        <div>
    <?php
        $sqlSelect = $connection->prepare("SELECT O_ID, UsrName, orderstatus.Order_Status from orders, people, orderstatus where orders.PersonID=people.P_ID and orders.Order_Status=orderstatus.Status_ID");
        $selectionWentOK = $sqlSelect->execute();
    
        if($selectionWentOK){
            $result= $sqlSelect->get_result();
            print "This is a list of all of your orders.";
        }
    ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Order Status</th>
                <th>View</th>
            </tr>
            <?php
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?= $row["O_ID"]?></td>
                        <td><?= $row["UsrName"]?></td>
                        <td><?= $row["Order_Status"]?></td>
                        <td><a href="viewOrders.php?orderID=<?= $row["O_ID"]?>">View Order</a></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>
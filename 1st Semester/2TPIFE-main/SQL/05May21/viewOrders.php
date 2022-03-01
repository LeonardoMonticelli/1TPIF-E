<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Current orders</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php
        include_once "dbConnect.php";
        include_once "adminCheck.php";
        include_once "navBar.php";

        if(!isset($_GET["orderID"])){
            print "Wrong access of this page. Please select an order to view and edit FIRST!";
        }

        if(isset($_GET["orderStatus"])){
            $updateOrder = $connection->prepare("UPDATE orders set Order_Status=? where O_ID=?");
            $updateOrder->bind_param("ii",$_GET["orderStatus"], $_GET["orderID"]);
            $updateOrder->execute();
            $updateOrder->close();
        }

    ?>
        This page will allow you to change the status id of order number: <?=$_GET["orderID"]?>
    <form action="" method="get">
        <input type="hidden" name="orderID" value=<?= $_GET["orderID"]?>>
        <select name="orderStatus" value="option">
            <?php
                $statusListSelect = $connection->prepare("SELECT * from orderstatus");
                $statusListSelect->execute();
                $results = $statusListSelect->get_result();
                $statusListSelect->close();
                while($row=$results->fetch_assoc()){
                    ?>
                        <option value=<?= $row["Status_ID"] ?><?php if(isset($_GET["orderStatus"]) && $_GET["orderStatus"] == $row["Status_ID"]){print "selected";}?>>
                            <?= $row["Order_Status"]?>
                        </option> 
                    <?php
                }
            ?>
        </select>
        <input type="submit" value="Save">
    </form>
</body>
</html>
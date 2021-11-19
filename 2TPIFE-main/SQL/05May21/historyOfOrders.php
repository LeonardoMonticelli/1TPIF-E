<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>History Of Orders</title>
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

       $transacitonHistory = $connection ->prepare("SELECT orders.O_ID, orderstatus.Order_Status from orders, orderstatus where orders.PersonID=(SELECT P_ID from people where UsrName=?) and orders.Order_Status = orderstatus.Status_ID");
       $transacitonHistory->bind_param("s",$_SESSION["currentUser"]);
       $transacitonHistory->execute();
       $result = $transacitonHistory->get_result();
       $transacitonHistory->close();
       print("<table>");
       while($row=$result->fetch_assoc()){
    ?>
        <tr>
            <td><?=$row["O_ID"]?></td>
            <td><?=$row["Order_Status"]?></td>
        </tr>
    <?php
       }
        print("</table>");
    ?>
</body>
</html>
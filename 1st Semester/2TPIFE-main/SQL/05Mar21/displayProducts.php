<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
   include_once("DBconnect.php");
    if(isset($_POST["filter"])){
        $stmt = $connection->prepare("SELECT * from Products where Price<=?");
        $stmt->bind_param("i", $_POST["filter"]);
    }
   else{
        $stmt = $connection->prepare("SELECT * from Products");
        if (!$stmt)
        {
            die ("Error in your sql statement...");
        }
    }
   //$stmt->bind_param("si", $_GET["wanted"], $_GET["maxAge"]);
    $stmt->execute();
    $myResult = $stmt->get_result();
   ?>
   <form action="" method="post">
        <input type="number" name="filter">
        <input type="submit" value="filter">
   </form>
   <?php
        if(isset($_POST["filter"])){
            $filter=true;
        } else{
            $filter=false;
        }
   ?>
    <table>
        <th>
            Product name
        </th>
        <th>
            Product price
        </th>
   <?php
    while($row = mysqli_fetch_assoc($myResult)) 
    {
        // if(isset($_POST["filter"]) && $row['Price'] > $_POST["filter"] && $_POST["filter"] != "") continue;

            ?>
            <tr><td><?=$row["ProductName"];?></td><td><?=$row["Price"];?></td></tr>   
            <?php 

    }
    ?>
    </table>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php 
        include_once("search.php");

        $stmt=$connection->prepare("SELECT * from wsers2.cars");
        if(!$stmt){
            die("There is an eror in your sql statement...");
        }

        $stmt->execute();
        $myResult = $stmt->get_result();
    ?>
        <table>
        <th>
            ID_CAR
        </th>
        <th>
            Brand   
        </th>
        <th>
            Model   
        </th>
        <th>
            Price   
        </th>
        <th>
            MaxSpeed   
        </th>
        <th>
            HPower   
        </th>

    <?php
    while($row = mysqli_fetch_assoc($myResult)) 
    {
        // if(isset($_POST["filter"]) && $row['Price'] > $_POST["filter"] && $_POST["filter"] != "") continue;

            ?>
            <tr><td><?=$row["ID_CAR"];?></td><td><?=$row["ID_CAR"];?></td><td><?=$row["Model"];?></td><td><?=$row["Price"];?></td><td><?=$row["MaxSpeed"];?></td><td><?=$row["HPower"];?></td></tr>   
            <?php 

    }
    ?>
    </table>
</body>
</html>
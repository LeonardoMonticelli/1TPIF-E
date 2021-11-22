<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
        </tr>
        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";

        $conn = new mysqli($servername, $username, $password, "cars");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if(isset($_GET["maxPrice"])){
            $sqlSelect = $conn->prepare("SELECT * from Cars where");
        }
        else{
            $sqlSelect = $conn->prepare("SELECT * from Cars");
        }
        // no bind - display all

        $sqlSelect->execute();
        $res = $sqlSelect->get_result();
        while($row = $res->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $row["CarName"] ?></td>
                <td><?= $row["CarPrice"] ?></td>
                <td><?= $row["CarDescription"] ?></td>
                <td><img src="./images/<?= $row["CarImage"] ?>"></td>
            </tr>
        <?php 
        }
        ?>
    </table>

</body>

</html>
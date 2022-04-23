<?php //head
    $pageTitle ="Administration";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>

<body>
    <?php //insert nav bar

    $result = $connection->query("SELECT * from user");

    if ($result) {
    
        ?>
            <table class="table">
                <thead>
                    <tr>

                        <th scope="col">UserNo</th>
                        <th scope="col">UserName</th>
                        <th scope="col">FirstName</th>
                        <th scope="col">LastName</th>
                        <th scope="col">Technician</th>
                        <th scope="col">Email</th>
                        <th scope="col"></th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) {?>                           
                        <tr>

                        <th scope="row"><?=  $row["UserNo"] ?></th>
                        <td><?=  $row["UserName"] ?></td>
                        <td><?=  $row["FirstName"] ?></td>
                        <td><?=  $row["LastName"] ?></td>
                        <td><?=  $row["Technician"] ?></td>
                        <td><?=  $row["Email"] ?></td>
                            <td>                                
                                <form method="POST">
                                    <input type="hidden" name="editUser" value="<?= $row["UserNo"] ?>">
                                    <input type="submit" value="Edit">
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="deleteUser" value="<?= $row["UserNo"] ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
<?php
        if(isset($_POST["deleteUser"])) {
            
            $deleteUser = intval($_POST["deleteUser"]);
            $sqlDelete = $connection->prepare("DELETE FROM user where UserNo=?");

            if(!$sqlDelete){
                die("Error: the USER cannot be deleted");
            }

            $sqlDelete->bind_param("i", $deleteUser);
            $sqlDelete->execute();
        }
        if(isset($_POST["editUser"])){

            $editUser = intval($_POST["editUser"]);
            $sqlSelect = $connection->prepare("SELECT UserName, FirstName, LastName, Technician, Email FROM user WHERE UserNo=?");
            $sqlSelect->bind_param("i", $editUser);
            $sqlSelect->execute();
            $result = $sqlSelect->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);

        }
//manage users
        $sqlSelect = $connection->prepare("SELECT * FROM user WHERE UserNo=?");
        $sqlSelect->bind_param("i", $createUserVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        while ($row = $result->fetch_assoc()) {
?>  
    <table class="table">
        <thead>
            <tr>

                <th scope="col">UserNo</th>
                <th scope="col">UserName</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
                <th scope="col">Technician</th>
                <th scope="col">Email</th>

            </tr>
        </thead>
    <?php
        }
    }
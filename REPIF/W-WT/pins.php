<?php //head
    $pageTitle ="Pin management";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
?>
    <body>
        <?php
            if($_SESSION["isUserLoggedIn"]==false){
                header("Location: index.php");
                exit;
            } else {
                include_once "navigationBar.php";
            }
 
            $result = $connection->query("SELECT * from Pin");
 
            if ($result) {
            
                ?>
                    <table class="table">
                        <thead>
                            <tr>
 
                                <th scope="col">HostName</th>
                                <th scope="col">PinNo</th>
                                <th scope="col">Input</th>
                                <th scope="col">Designation</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
 
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) {?>                           
                                <tr>
 
                                    <th scope="row"><?= $row["HostName"] ?></th>
                                    <td><?= $row["PinNo"] ?></td>
                                    <td><?= $row["Input"] ?></td>
                                    <td><?= $row["Designation"] ?></td>
                                    <td>                                
                                        <form method="POST">
                                            <input type="hidden" name="editPin" value="<?= $row["PinNo"] ?>">
                                            <input type="submit" value="Edit">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="deletePin" value="<?= $row["PinNo"] ?>">
                                            <input type="submit" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
        <?php
                if(isset($_POST["deletePin"])) {
                    $deletePinVal = intval($_POST["deletePin"]);
                    $sqlDelete = $connection->prepare("DELETE FROM pin where PinNo=?");
                    if(!$sqlDelete){
                        die("Error: the PIN cannot be deleted");
                    }
                    $sqlDelete->bind_param("i", $deletePinVal);
                    $sqlDelete->execute();
                }
                if(isset($_POST["editPin"])){
                    $editPinVal = intval($_POST["editPin"]);
                    $sqlSelect = $connection->prepare("SELECT HostName, PinNo, Input, Designation FROM pin WHERE PinNo=?");
                    $sqlSelect->bind_param("i", $editPinVal);
                    $sqlSelect->execute();
                    $result = $sqlSelect->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);
                    // if(!$data) echo "no data";
                    // else var_dump($data);
                    ?>
                    <form method="post">
 
                        <div class="form-group">
                            <label for="">HostName</label>
                            <input type="text" class="form-control" name="hostNameEdit" value="<?= $data[0]["HostName"] ?>">
                        </div>
 
                        <div class="form-group">
                            <label for="">PinNo</label>
                            <input type="text" class="form-control" name="pinNoEdit" value="<?= $data[0]["PinNo"] ?>">
                        </div>
 
                        <div class="form-group">
                            <label for="">Input</label>
                            <input type="text" class="form-control" name="inputEdit" value="<?= $data[0]["Input"] ?>">
                        </div>
 
                        <div class="form-group">
                            <label for="">Designation</label>
                            <input type="text" class="form-control" name="designationEdit" value="<?= $data[0]["Designation"] ?>">
                        </div>
 
                        <button type="submit" class="btn btn-primary">Submit</button>
 
                    </form>
                    <?php
                    $sqlDelete = $connection->prepare("UPDATE pin SET HostName=?, PinNo=?, Input=?, Designation=? where PinNo=?");
                    if(!$sqlDelete){
                        die("Error: the PIN cannot be updated");
                    }
                    $sqlDelete->bind_param("siisi", $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["inputEdit"], $_POST["designationEdit"], $editPinVal);
                    $sqlDelete->execute();
                }
            }  else {
                print "Something went wrong selecting data";
            }
        ?>
    </body>
</html>
 
<!-- SELECT * FROM Script s LEFT JOIN `use` u ON s.ScriptName = u.ScriptName LEFT JOIN `group` g ON g.GroupNo = u.GroupNo LEFT JOIN `SmartBox` b ON b.HostName = g.HostName; -->
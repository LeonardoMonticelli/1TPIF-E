<?php //head
    $pageTitle ="Administration";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>

<body>
<?php

    $result = $connection->query("SELECT * from script");

    if($result){?>
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

                        <th scope="row"><?= $row["ScriptName"] ?></th>
                        <td><?= $row["Path"] ?></td>
                        <td><?= $row["Description"] ?></td>
                        <td>                                
                            <form method="POST">
                                <input type="hidden" name="editScript" value="<?= $row["ScriptName"] ?>">
                                <input type="submit" value="Edit">
                            </form>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="deleteScript" value="<?= $row["ScriptName"] ?>">
                                <input type="submit" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>

<?php
    } else {
        print "Something went wrong with selecting data";
    }

    if(isset($_POST["ScriptName"], $_POST["Path"], $_POST["Description"])){
        $sqlInsert = $connection->prepare("INSERT INTO Script (ScriptName, Path, Description) values (?,?,?)");
        $sqlInsert->bind_param("sss", $_POST["ScriptName"], $_POST["Path"], $_POST["Description"]);
        $resultOfExecute = $sqlInsert->execute();
        if(!$resultOfExecute){
            print "Adding a new script, failed";
        }
    }
    ?>

    </table>

    <form method="POST">
        Add a New Script: <input name="ScriptName" placeholder="Dimmer">
        <input name="Path" placeholder="/Switch/Dimmer.sh">
        <input name="Description" placeholder="Dim Lamp">
        <input type="submit" value="Add">
    </form>

    <?php
        
        if(isset($_POST["editPin"])){ //edit does not work
    
            $editPinVal = intval($_POST["editPin"]);
            $sqlSelect = $connection->prepare("SELECT HostName, PinNo, Input, Designation FROM pin WHERE PinNo=?");
            $sqlSelect->bind_param("i", $editPinVal);
            $sqlSelect->execute();
            $result = $sqlSelect->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
    
            ?>
            <form method="post">
    
                <div class="form-group mb-3">
                    <label for="">HostName</label>
                    <input type="text" class="form-control" name="hostNameEdit" value="<?= $data[0]["HostName"] ?>">
                </div>
    
                <div class="form-group mb-3">
                    <label for="">PinNo</label>
                    <input type="text" class="form-control" name="pinNoEdit" value="<?= $data[0]["PinNo"] ?>">
                </div>
    
                <div class="form-group mb-3">
                    <label for="">Input</label>
                    <input type="text" class="form-control" name="inputEdit" value="<?= $data[0]["Input"] ?>">
                </div>
    
                <div class="form-group mb-3">
                    <label for="">Designation</label>
                    <input type="text" class="form-control" name="designationEdit" value="<?= $data[0]["Designation"] ?>">
                </div>
    
                <button type="submit" class="btn btn-primary">Submit</button>
    
            </form>
            <?php
    
            $sqlUpdate = $connection->prepare("UPDATE pin SET HostName=?, PinNo=?, Input=?, Designation=? where PinNo=?");
    
            if(!$sqlUpdate){
                die("Error: the PIN cannot be updated");
            }
    
            $sqlUpdate->bind_param("siisi", $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["inputEdit"], $_POST["designationEdit"], $editPinVal);
            $sqlUpdate->execute();
    
        }

        if(isset($_POST["deleteScript"])) {

            $deletePinVal = intval($_POST["deleteScript"]);
            $sqlDelete = $connection->prepare("DELETE FROM script where ScriptName=?");
    
            if(!$sqlDelete){
                die("Error: the SCRIPT cannot be deleted");
            }
    
            $sqlDelete->bind_param("i", $deletePinVal);
            $sqlDelete->execute();
    
        }

            ?>

</body>

</html>
<?php
//create a panel where to put the script, and name the script, and the description will be the content


?>
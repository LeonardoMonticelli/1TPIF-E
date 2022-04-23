<?php //head
    $pageTitle ="Pin management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>
        <?php

            $result = $connection->query("SELECT * from Pin");
 
            if ($result) {

                if(isset($_POST["deletePin"])) { //this has to be at the beggining so the refresh works 

                    $deletePinVal = intval($_POST["deletePin"]);
                    $sqlDelete = $connection->prepare("DELETE FROM pin where PinNo=?");
    
                    if(!$sqlDelete){
                        die("Error: the PIN cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("i", $deletePinVal);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["hostNameEdit"])&&!empty($_POST["pinNoEdit"])&&!empty($_POST["inputEdit"])&&!empty($_POST["designationEdit"])){ //update
                    echo "trying to update";
                    $sqlUpdate = $connection->prepare("UPDATE pin SET HostName=?, PinNo=?, Input=?, Designation=? where PinNo=?");
        
                    if(!$sqlUpdate){
                        die("Error: the PIN cannot be updated");
                    }

                    $sqlUpdate->bind_param("siisi", $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["inputEdit"], $_POST["designationEdit"], $_POST["pinNoSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
            
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
            }  else {
                print "Something went wrong selecting data";
            }
    
    if(isset($_POST["editPin"])){

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

                <select name="hostNameEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT HostName FROM smartbox");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();
                        while($row = $result->fetch_assoc()){
                            ?>
                            <option <?php if($data[0]["HostName"]==$row["HostName"]){print " selected ";}?>value="<?=$row["HostName"]?>"><?= $row["HostName"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">PinNo</label>
                <input type="text" class="form-control" name="pinNoEdit" value="<?= $data[0]["PinNo"] ?>">
                <input type="hidden" class="form-control" name="pinNoSearch" value="<?= $data[0]["PinNo"] ?>">
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
    }    
        ?>
    </body>
</html>
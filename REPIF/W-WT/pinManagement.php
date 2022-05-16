<?php //head
    $pageTitle ="Pin management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
?>
    <body>
    <div class="">
            <form action="" method="post">
                <input type="hidden" name="goBack">
                <input type="submit" class="btn btn-secondary mb-3" value="Go back">
            </form>
        </div>
        <?php
                    if(isset($_POST["goBack"])){
                        header("location: pinHome.php");
                    }
            // $lednumbers = [ 7, 8, 12, 16, 20, 21];
            // $switches = [ 5, 11, 9, 10, 4, 22, 27];
            $pins = [ 4, 5, 7, 8, 9, 10, 11, 12, 16, 18, 19, 20, 21, 22, 23, 27];
 
            if($_SESSION["userIsAdmin"]==0){

                $sqlStatement = $connection->prepare("SELECT * from pins, manage where pins.HostName=manage.HostName and manage.UserNo=? and pins.HostName=?");
                $sqlStatement->bind_param("is", $_SESSION["currentUserNo"], $_GET["HostName"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();

            }else{
                $sqlStatement = $connection->prepare("SELECT * from pins where HostName=?");
                $sqlStatement->bind_param("s", $_GET["HostName"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();
            }

            if ($result) {

                if(isset($_POST["deletePin"])) { //this has to be at the beggining so the refresh works 

                    $deletePinVal = intval($_POST["deletePin"]);
                    $sqlDelete = $connection->prepare("DELETE FROM pins where PinId=?");
    
                    if(!$sqlDelete){
                        die("Error: the pins cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("i", $deletePinVal);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["hostNameEdit"])&&!empty($_POST["pinNoEdit"])&&!empty($_POST["inputEdit"])&&!empty($_POST["designationEdit"])){ //update

                    $sqlUpdate = $connection->prepare("UPDATE pins SET HostName=?, PinNo=?, Input=?, Designation=? where PinId=?");
        
                    if(!$sqlUpdate){
                        die("Error: the pins cannot be updated");
                    }

                    $sqlUpdate->bind_param("siisi", $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["inputEdit"], $_POST["designationEdit"], $_POST["pinIdSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }

                if(!empty($_POST["pinNoCreate"])&&!empty($_POST["hostNameCreate"])&&!empty($_POST["inputCreate"])&&!empty($_POST["designationCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `pins` (`PinNo`, `HostName`, `Input`, `Designation`) VALUES (?,    ?,    ?,    ?)");

                    if(!$sqlCreate){
                        die("Error: the pins cannot be created");
                    }

                    $sqlCreate->bind_param("isis", $_POST["pinNoCreate"], $_POST["hostNameCreate"], $_POST["inputCreate"], $_POST["designationCreate"]);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }
            
                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">ID</th>
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

                                <th scope="row"><?= $row["PinId"] ?></th>
                                <td><?= $row["HostName"] ?></td>
                                <td><?= $row["PinNo"] ?></td>
                                <td><?= $row["Input"] ?></td>
                                <td><?= $row["Designation"] ?></td>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="editPin" value="<?= $row["PinId"] ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="deletePin" value="<?= $row["PinId"] ?>">
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
        $sqlSelect = $connection->prepare("SELECT PinId, HostName, PinNo, Input, Designation FROM pins WHERE PinId=?");
        $sqlSelect->bind_param("i", $editPinVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post">
            <?php if($_SESSION["userIsAdmin"]==1){ ?>
                <div class="form-group mb-3">
                    <label for="">HostName</label>

                    <select name="hostNameEdit" class="form-select">
                        <?php
                            $sqlSelect = $connection->prepare("SELECT HostName FROM smartboxes");
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
           <?php } else {?>
            
                <div class=" mb-3">
                    <fieldset disabled>
                        <label for="">HostName</label>
                        <input type="text" id="disabledTextInput" class="form-control" name="" placeholder="<?= $data[0]["HostName"] ?>">
                    </fieldset>
                    <input type="hidden" class="form-control" name="hostNameEdit" value="<?= $data[0]["HostName"] ?>">
                </div>

            <?php } ?>

            <input type="hidden" class="form-control" name="pinIdSearch" value="<?= $data[0]["PinId"] ?>">

            <div class="form-group mb-3">
                <label for="">PinNo</label>

                <select name="pinNoEdit" class="form-select">
                        <?php

                            foreach($pins as $pin) {
                                ?>
                                <option <?php if($data[0]["PinNo"]==$pin){print " selected ";}?> value="<?=$pin?>"><?= $pin ?></option>
                                <?php
                            }
                        ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">Input</label>

                <select name="inputEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT Input FROM pins GROUP BY Input HAVING COUNT(*) > 1");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){
                            ?>
                            <option <?php if($data[0]["Input"]==$row["Input"]){print " selected ";}?>value="<?=$row["Input"]?>"><?= $row["Input"]?></option>
                            <?php
                        }
                    ?>
                </select>

            </div>

            <div class="form-group mb-3">
                <label for="">Designation</label>
                <input type="text" class="form-control" name="designationEdit" value="<?= $data[0]["Designation"] ?>">
            </div>

            <button type="submit" class="btn btn-success mb-3">Submit</button>

        </form>
        <?php
    }    
        ?>
<div>

</div class="mb-3">
    <form action="" method="post">
        <input type="hidden" name="createPin">
        <input type="submit" class="btn btn-primary" value="Create"></input>
    </form>



    <?php
    if(isset($_POST["createPin"])){

    ?>
        <form method="post">
           <?php if($_SESSION["userIsAdmin"]==1){ ?>
                <div class="form-group mb-3">
                    <label for="">HostName</label>

                    <select name="hostNameCreate" class="form-select">
                        <?php
                            $sqlSelect = $connection->prepare("SELECT HostName FROM smartboxes");
                            $sqlSelect->execute();
                            $result = $sqlSelect->get_result();

                            while($row = $result->fetch_assoc()){
                                ?>
                                <option value="<?=$row["HostName"]?>"><?= $row["HostName"]?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
           <?php } else {
                    $sqlSelect = $connection->prepare("SELECT * from smartboxes, manage where smartboxes.HostName=manage.HostName and manage.UserNo=?");
                    $sqlSelect->bind_param("i", $_SESSION["currentUserNo"]);
                    $sqlSelect->execute();
                    $result = $sqlSelect->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);
               ?>

                <div class=" mb-3">
                    <fieldset disabled>
                        <label for="">HostName</label>
                        <input type="text" id="disabledTextInput" class="form-control" name="" value="<?=$data[0]["HostName"]?>">
                    </fieldset>
                    <input type="hidden" class="form-control" name="hostNameCreate" value="<?=$data[0]["HostName"]?>">
                </div>

            <?php } ?>
            
            <div class="form-group mb-3">
                <label for="">PinNo</label>
                <select name="pinNoCreate" class="form-select">
                        <?php

                            foreach($pins as $pin) {
                                ?>
                                <option value="<?=$pin?>"><?= $pin ?></option>
                                <?php
                            }
                        ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">Input</label>

                <select name="inputCreate" class="form-select">
                    <option value="0">0</option>
                    <option value="1">1</option>
                </select>

            </div>

            <div class="form-group mb-3">
                <label for="">Designation</label>
                <input type="text" class="form-control" name="designationCreate" placeholder="GPIO#">
            </div>

            <button type="submit" class="btn btn-success mb-3">Create a pins</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
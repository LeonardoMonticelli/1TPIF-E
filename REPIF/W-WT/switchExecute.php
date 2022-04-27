<?php //head
    $pageTitle ="Switch Pins";
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
        <div>This is where the Groups and the Switch Pins are connected</div>
        <?php

            if(isset($_POST["goBack"])){
                header("location: sbManagement.php");
            }

            $sqlSelect = $connection->prepare("SELECT * from switchexecute WHERE HostName=?");
            $sqlSelect->bind_param("s", $_GET["HostName"]);
            $sqlSelect->execute();
            $result = $sqlSelect->get_result();
            
            if ($result) {

                if(isset($_POST["deleteConnection"])) { //delete

                    $deleteConVal = intval($_POST["deleteConnection"]);
                    $sqlDelete = $connection->prepare("DELETE FROM switchexecute where SwitchExecuteId=?");
    
                    if(!$sqlDelete){
                        die("Error: the CONNECTION cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("i", $deleteConVal);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                $isItEmptyEdit = !empty($_POST["hostNameEdit"])&&!empty($_POST["pinNoEdit"])&&!empty($_POST["eventCodeEdit"])&&!empty($_POST["groupNoEdit"])&&!empty($_POST["targetFunctionCodeEdit"])&&!empty($_POST["descriptionEdit"])&&!empty($_POST["sequenceNoEdit"])&&!empty($_POST["waitingDurationEdit"]);
                if($isItEmptyEdit){ //update
                    
                    $sqlUpdate = $connection->prepare("UPDATE switchexecute SET HostName=?, PinNo=?, EventCode=?, GroupNo=?, TargetFunctionCode=?, `Description`=?, SequenceNo=?, WaitingDuration=? where SwitchExecuteId=?");
                    
                    if(!$sqlUpdate){
                        die("Error: the CONNECTION cannot be updated");
                    }

                    $sqlUpdate->bind_param("sisissiii", $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["eventCodeEdit"], $_POST["groupNoEdit"],$_POST["targetFunctionCodeEdit"],$_POST["descriptionEdit"], $_POST["sequenceNoEdit"], $_POST["waitingDurationEdit"], $_POST["switchExecuteIdSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
                
                $isItEmptyCreate = !empty($_POST["hostNameCreate"])&&!empty($_POST["pinNoCreate"])&&!empty($_POST["eventCodeCreate"])&&!empty($_POST["groupNoCreate"])&&!empty($_POST["targetFunctionCodeCreate"])&&!empty($_POST["descriptionCreate"])&&!empty($_POST["sequenceNoCreate"])&&!empty($_POST["waitingDurationCreate"]);
                if($isItEmptyCreate){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `switchexecute` (`HostName`, `PinNo`, `EventCode`, `GroupNo`, `TargetFunctionCode`, `Description`, `SequenceNo`, `WaitingDuration`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the CONNECTION cannot be created");
                    }

                    $sqlCreate->bind_param("sisissii", $_POST["hostNameCreate"], $_POST["pinNoCreate"], $_POST["eventCodeCreate"], $_POST["groupNoCreate"],$_POST["targetFunctionCodeCreate"],$_POST["descriptionCreate"], $_POST["sequenceNoCreate"], $_POST["waitingDurationCodeCreate"]);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">HostName</th>
                            <th scope="col">PinNo</th>
                            <th scope="col">EventCode</th>
                            <th scope="col">GroupNo</th>
                            <th scope="col">TargetFunctionCode</th>
                            <th scope="col">Description</th>
                            <th scope="col">SequenceNo</th>
                            <th scope="col">WaitingDuration</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["HostName"] ?></th>
                                <td><?= $row["PinNo"] ?></td>
                                <td><?= $row["EventCode"] ?></td>
                                <td><?= $row["GroupNo"] ?></td>
                                <td><?= $row["TargetFunctionCode"] ?></td>
                                <td><?= $row["Description"] ?></td>
                                <td><?= $row["SequenceNo"] ?></td>
                                <td><?= $row["WaitingDuration"] ?></td>

                                <?php if($_SESSION["userIsAdmin"]==1){?>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="editConnection" value="<?= $row["SwitchExecuteId"] ?>">
                                            <input type="submit" value="Edit">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="deleteConnection" value="<?= $row["SwitchExecuteId"] ?>">
                                            <input type="submit" value="Delete">
                                        </form>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
<?php
            }  else {
                print "Something went wrong selecting data";
            }
    
    if(isset($_POST["editConnection"])){

        $editConVal = intval($_POST["editConnection"]);
        $sqlSelect = $connection->prepare("SELECT SwitchExecuteId, HostName, PinNo, EventCode, GroupNo, TargetFunctionCode, `Description`, SequenceNo, WaitingDuration FROM switchexecute WHERE SwitchExecuteId=?");
        $sqlSelect->bind_param("i", $editConVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <fieldset disabled>
                <div class="form-group mb-3">
                    <label for="">SwitchExecuteId</label>
                    <input type="text" class="form-control" name="" value="<?= $data[0]["SwitchExecuteId"] ?>">
                </div>
            </fieldset>

            <input type="hidden" class="form-control" name="switchExecuteIdEdit" value="<?= $data[0]["SwitchExecuteId"] ?>">
            <input type="hidden" class="form-control" name="switchExecuteIdSearch" value="<?= $data[0]["SwitchExecuteId"] ?>">

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

            <div class="form-group mb-3">
                <label for="">PinNo</label>

                <select name="pinNoEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT PinNo FROM pins WHERE Input=1");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){

                            ?>
                            <option <?php if($data[0]["PinNo"]==$row["PinNo"]){print " selected ";}?>value="<?=$row["PinNo"]?>"><?= $row["PinNo"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">EventCode</label>

                <select name="eventCodeEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT EventCode FROM events");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){

                            ?>
                            <option <?php if($data[0]["EventCode"]==$row["EventCode"]){print " selected ";}?>value="<?=$row["EventCode"]?>"><?= $row["EventCode"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">GroupNo</label>

                <select name="groupNoEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT GroupNo FROM groups");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){

                            ?>
                            <option <?php if($data[0]["GroupNo"]==$row["GroupNo"]){print " selected ";}?>value="<?=$row["GroupNo"]?>"><?= $row["GroupNo"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">TargetFunctionCode</label>
                <input type="text" class="form-control" name="targetFunctionCodeEdit" value="<?= $data[0]["TargetFunctionCode"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">SequenceNo</label>
                <input type="text" class="form-control" name="sequenceNoEdit" value="<?= $data[0]["SequenceNo"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">WaitingDuration</label>
                <input type="text" class="form-control" name="waitingDurationEdit" value="<?= $data[0]["WaitingDuration"] ?>">
            </div>

            <button type="submit" class="btn btn-success">Submit</button>

        </form>
        <?php
    }    
        ?>

    <form action="" method="post">  
        <input type="hidden" name="createExecute">
        <input type="submit" class="btn btn-primary" value="Create">
    </form>

<?php
    if(isset($_POST["createExecute"])){

        $sqlSelect = $connection->prepare("SELECT SwitchExecuteId, HostName, PinNo, EventCode, GroupNo FROM switchexecute");

        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

    ?>
        <form method="post">

        <fieldset disabled>
                <div class="form-group mb-3">
                    <label for="">SwitchExecuteId</label>
                    <input type="text" class="form-control" name="" value="<?= $data[0]["SwitchExecuteId"] ?>">
                </div>
            </fieldset>

            <input type="hidden" class="form-control" name="switchExecuteIdCreate" value="<?= $data[0]["SwitchExecuteId"] ?>">
            <input type="hidden" class="form-control" name="switchExecuteIdSearch" value="<?= $data[0]["SwitchExecuteId"] ?>">

            <div class="form-group mb-3">
                <label for="">HostName</label>

                <select name="hostNameCreate" class="form-select">
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

            <div class="form-group mb-3">
                <label for="">PinNo</label>

                <select name="pinNoCreate" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT PinNo FROM pins WHERE Input=1");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){

                            ?>
                            <option <?php if($data[0]["PinNo"]==$row["PinNo"]){print " selected ";}?>value="<?=$row["PinNo"]?>"><?= $row["PinNo"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">EventCode</label>

                <select name="eventCodeCreate" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT EventCode FROM events");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){

                            ?>
                            <option <?php if($data[0]["EventCode"]==$row["EventCode"]){print " selected ";}?>value="<?=$row["EventCode"]?>"><?= $row["EventCode"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">GroupNo</label>

                <select name="groupNoCreate" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT GroupNo FROM groups");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){

                            ?>
                            <option <?php if($data[0]["GroupNo"]==$row["GroupNo"]){print " selected ";}?>value="<?=$row["GroupNo"]?>"><?= $row["GroupNo"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">TargetFunctionCode</label>
                <input type="text" class="form-control" name="targetFunctionCodeCreate" placeholder="A, E, U">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionCreate" placeholder="Switch located at...">
            </div>

            <div class="form-group mb-3">
                <label for="">SequenceNo</label>
                <input type="text" class="form-control" name="sequenceNoCreate" placeholder="1">
            </div>

            <div class="form-group mb-3">
                <label for="">WaitingDuration</label>
                <input type="text" class="form-control" name="waitingDurationCreate" placeholder="1">
            </div>

            <button type="submit" class="btn btn-success">Create a Switch connection</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
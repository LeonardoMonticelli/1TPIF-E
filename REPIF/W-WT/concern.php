<?php //head
    //must it have only the ones with input=1?
    $pageTitle ="LED Pins";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
?>
    <body>
        <div class="btn">
            <form action="" method="post">
                <input type="hidden" name="goBack">
                <input type="submit" value="Go back">
            </form>
        </div>
        <div>This is where the Groups and the LED Pins are connected</div>
        <?php

            if(isset($_POST["goBack"])){
                header("location: groups.php");
            }

            $result = $connection->query("SELECT * from concern");

            if ($result) {

                if(isset($_POST["deleteConnection"])) { //delete

                    $deleteConVal = intval($_POST["deleteConnection"]);
                    $sqlDelete = $connection->prepare("DELETE FROM concern where ConcernId=?");
    
                    if(!$sqlDelete){
                        die("Error: the CONNECTION cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("i", $deleteConVal);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["groupNoEdit"])&&!empty($_POST["hostNameEdit"])&&!empty($_POST["pinNoEdit"])){ //update
                    //monle399
                    $sqlUpdate = $connection->prepare("UPDATE concern SET GroupNo=?, HostName=?, `PinNo`=? where ConcernId=?");
        
                    if(!$sqlUpdate){
                        die("Error: the CONNECTION cannot be updated");
                    }

                    $sqlUpdate->bind_param("isii", $_POST["groupNoEdit"], $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["concernIdSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
                   
                if(!empty($_POST["groupNoCreate"])&&!empty($_POST["hostNameCreate"])&&!empty($_POST["pinNoCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `concern` (`GroupNo`, `HostName`, `PinNo`) VALUES (?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the CONNECTION cannot be created");
                    }

                    $sqlCreate->bind_param("isi",  $_POST["groupNoCreate"], $_POST["hostNameCreate"], $_POST["pinNoCreate"]);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">ConcernId</th>
                            <th scope="col">GroupNo</th>
                            <th scope="col">HostName</th>
                            <th scope="col">PinNo</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["ConcernId"] ?></th>
                                <td><?= $row["GroupNo"] ?></td>
                                <td><?= $row["HostName"] ?></td>
                                <td><?= $row["PinNo"] ?></td>
                                <?php if($_SESSION["userIsAdmin"]==1){?>
                                    <td>                                
                                        <form method="POST">
                                            <input type="hidden" name="editConnection" value="<?= $row["ConcernId"] ?>">
                                            <input type="submit" value="Edit">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="deleteConnection" value="<?= $row["ConcernId"] ?>">
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
        $sqlSelect = $connection->prepare("SELECT ConcernId, GroupNo, HostName, PinNo FROM concern WHERE ConcernId=?");
        $sqlSelect->bind_param("i", $editConVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <fieldset disabled>
                <div class="form-group mb-3">
                    <label for="">ConcernId</label>
                    <input type="text" class="form-control" name="" value="<?= $data[0]["ConcernId"] ?>">
                </div>
            </fieldset>

            <input type="hidden" class="form-control" name="concernIdEdit" value="<?= $data[0]["ConcernId"] ?>">
            <input type="hidden" class="form-control" name="concernIdSearch" value="<?= $data[0]["ConcernId"] ?>">

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
                        $sqlSelect = $connection->prepare("SELECT PinNo FROM pins WHERE Input=0");
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

            <button type="submit" class="btn btn-success">Submit</button>

        </form>
        <?php
    }    
        ?>

    <form action="" method="post">  
        <input type="hidden" name="createGroup">
        <input type="submit" class="btn btn-primary" value="Create">
    </form>

<?php
    if(isset($_POST["createGroup"])){

        $sqlSelect = $connection->prepare("SELECT ConcernId, GroupNo, HostName, PinNo FROM concern");

        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

    ?>
        <form method="post">

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
                        $sqlSelect = $connection->prepare("SELECT PinNo FROM pins WHERE Input=0");
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

            <button type="submit" class="btn btn-success">Create a group</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
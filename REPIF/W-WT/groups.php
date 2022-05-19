 <?php //head
    $pageTitle ="Group management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>
        <?php
        //add a button in general to add pins to each group (concern) redirect to the concern

        if(isset($_POST["addPins"])) { 

            $sqlSelect = $connection->prepare("SELECT GroupNo, HostName FROM `groups` WHERE GroupNo=?");
            $sqlSelect->bind_param("i", $_POST["addPins"]);
            $sqlSelect->execute();
            $result = $sqlSelect->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);

            header("location: concern.php?GroupNo=".$data[0]["GroupNo"]."&HostName=".$data[0]["HostName"]);

        }

        if(isset($_POST["viewScripts"])) { 

            $sqlSelect = $connection->prepare("SELECT GroupNo FROM `groups` WHERE GroupNo=?");
            $sqlSelect->bind_param("i", $_POST["viewScripts"]);
            $sqlSelect->execute();
            $result = $sqlSelect->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);

            header("location: script.php?GroupNo=".$data[0]["GroupNo"]);

        }

            if($_SESSION["userIsAdmin"]==0){

                $sqlStatement = $connection->prepare("SELECT * from `groups`, manage where `groups`.HostName=manage.HostName and UserNo=?");
                $sqlStatement->bind_param("i", $_SESSION["currentUserNo"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();

            }else{
                $result = $connection->query("SELECT * from `groups`");
            }
 
            if ($result) {

                if(isset($_POST["deleteGroup"])) { //this has to be at the beggining so the refresh works 

                    $deleteGroupVal = intval($_POST["deleteGroup"]);
                    $sqlDelete = $connection->prepare("DELETE FROM `groups` where GroupNo=?");
    
                    if(!$sqlDelete){
                        die("Error: the GROUP cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("i", $deleteGroupVal);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["groupNoEdit"])&&!empty($_POST["groupNameEdit"])&&!empty($_POST["descriptionEdit"])&&!empty($_POST["hostNameEdit"])){ //update
                    //monle399
                    $sqlUpdate = $connection->prepare("UPDATE `groups` SET GroupNo=?, GroupName=?, `Description`=?, HostName=? where GroupNo=?");
        
                    if(!$sqlUpdate){
                        die("Error: the users cannot be updated");
                    }

                    $sqlUpdate->bind_param("isssi", $_POST["groupNoEdit"], $_POST["groupNameEdit"], $_POST["descriptionEdit"], $_POST["hostNameEdit"], $_POST["groupNoSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
                   
                if(!empty($_POST["groupNoCreate"])&&!empty($_POST["groupNameCreate"])&&!empty($_POST["descriptionCreate"])&&!empty($_POST["hostNameCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `groups` (`GroupNo`, `GroupName`, `Description`, `HostName`) VALUES (?, ?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the users cannot be created");
                    }

                    $sqlCreate->bind_param("isss",  $_POST["groupNoCreate"], $_POST["groupNameCreate"], $_POST["descriptionCreate"], $_POST["hostNameCreate"]);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">GroupNo</th>
                            <th scope="col">GroupName</th>
                            <th scope="col">Description</th>
                            <th scope="col">HostName</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["GroupNo"] ?></th>
                                <td><?= $row["GroupName"] ?></td>
                                <td><?= $row["Description"] ?></td>
                                <td><?= $row["HostName"] ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="addPins" value="<?= $row["GroupNo"] ?>">
                                        <input type="submit" class="btn btn-primary" value="Add LED Pins"></input>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="viewScripts" value="<?= $row["GroupNo"] ?>">
                                        <input type="submit" class="btn btn-secondary" value="View Scripts"></input>
                                    </form>
                                </td>
                                <?php if($_SESSION["userIsAdmin"]==1){?>
                                    <td>                                
                                        <form method="POST">
                                            <input type="hidden" name="editGroup" value="<?= $row["GroupNo"] ?>">
                                            <input type="submit" value="Edit">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="deleteGroup" value="<?= $row["GroupNo"] ?>">
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
    
    if(isset($_POST["editGroup"])){

        $editGroupVal = intval($_POST["editGroup"]);
        $sqlSelect = $connection->prepare("SELECT * FROM `groups` WHERE GroupNo=?");
        $sqlSelect->bind_param("i", $editGroupVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <div class="form-group mb-3">
                <label for="">GroupNo</label>
                <input type="text" class="form-control" name="groupNoEdit" value="<?= $data[0]["GroupNo"] ?>">
                <input type="hidden" class="form-control" name="groupNoSearch" value="<?= $data[0]["GroupNo"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">GroupName</label>
                <input type="text" class="form-control" name="groupNameEdit" value="<?= $data[0]["GroupName"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
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

            <button type="submit" class="btn btn-success">Submit</button>

        </form>
        <?php
    }    
        ?>
        <div class="mb-3">
            <form action="" method="post">  
                <input type="hidden" name="createGroup">
                <input type="submit" class="btn btn-primary" value="Create">
            </form>
        </div>

<?php

    if(isset($_POST["createGroup"])){

    ?>
        <form method="post">

            <div class="form-group mb-3">
                <label for="">GroupNo</label>
                <input type="number" class="form-control" name="groupNoCreate" placeholder="Group Number">
            </div>

            <div class="form-group mb-3">
                <label for="">GroupName</label>
                <input type="text" class="form-control" name="groupNameCreate" placeholder="Kitchen, First floor...">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionCreate" placeholder="Kitchen lights...">
            </div>

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

            <button type="submit" class="btn btn-success">Create a group</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
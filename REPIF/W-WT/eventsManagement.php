<?php //head

    $pageTitle ="Events";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";

?>
    <body>
        <?php

            $sqlStatement = $connection->prepare("SELECT * from events"); 
            $sqlStatement->execute();

            $result = $sqlStatement->get_result();
             
            if ($result) {

                if(isset($_POST["deleteEvent"])) { //this has to be at the beggining so the refresh works 

                    $sqlDelete = $connection->prepare("DELETE FROM events where EventId=?");
    
                    if(!$sqlDelete){
                        die("Error: the event cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("i", $_POST["deleteEvent"]);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["hostNameEdit"])&&!empty($_POST["userNoEdit"])){ //update

                    $sqlUpdate = $connection->prepare("UPDATE events SET `HostName`=?, UserNo=? where EventId=?"); //fine
        
                    if(!$sqlUpdate){
                        die("Error: the smartboxes cannot be updated");
                    }
                    
                    $sqlUpdate->bind_param("sii", $_POST["hostNameEdit"], $_POST["userNoEdit"], $_POST["manageIdSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
 
                if(!empty($_POST["hostNameCreate"])&&!empty($_POST["userNoCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `events` (`HostName`, `UserNo`) VALUES (?,    ?)");

                    if(!$sqlCreate){
                        die("Error: the smartboxes cannot be created");
                    }

                    $sqlCreate->bind_param("ss", $_POST["hostNameCreate"], $_POST["userNoCreate"]);
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
                            <th scope="col">Description</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["EventId"] ?></th>
                                <td><?= $row["HostName"] ?></td>
                                <td><?= $row["UserNo"] ?></td>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="editManage" value="<?= $row["EventId"] ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="deleteEvent" value="<?= $row["EventId"] ?>">
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
    
    if(isset($_POST["editManage"])){

        $sqlSelect = $connection->prepare("SELECT EventId, HostName, UserNo FROM events WHERE EventId=?");
        $sqlSelect->bind_param("i", $_POST["editManage"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">
            <div class=" mb-3">
                <fieldset disabled>
                    <label for="">EventId</label>
                    <input type="text" id="disabledTextInput" class="form-control" name="" placeholder="<?= $data[0]["EventId"] ?>">
                </fieldset>
                <input type="hidden" class="form-control" name="manageIdSearch" value="<?= $data[0]["EventId"] ?>">
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
                <label for="">UserNo</label>

                <select name="userNoEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT UserNo FROM users");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){
                            ?>
                            <option <?php if($data[0]["UserNo"]==$row["UserNo"]){print " selected ";}?>value="<?=$row["UserNo"]?>"><?= $row["UserNo"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success  mb-3">Submit changes</button>

        </form>

        <?php
    }    
    if($_SESSION["userIsAdmin"]==1){
?>  
        <div class="mb-3">
            <form action="" method="post">
                <input type="hidden" name="createManage">
                <input type="submit" class="btn btn-primary" value="Create"></input>
            </form>
        </div>
<?php
    }
    if(isset($_POST["createManage"])){

        ?>
        <form method="post">


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

            <div class="form-group mb-3">
                <label for="">UserNo</label>

                <select name="userNoCreate" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT UserNo FROM users");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){
                            ?>
                            <option value="<?=$row["UserNo"]?>"><?= $row["UserNo"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create a permission</button>

        </form>
        <?php
    }

        ?>
    </body>
</html>
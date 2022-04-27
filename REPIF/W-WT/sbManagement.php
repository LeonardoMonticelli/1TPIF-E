<?php //head
    $pageTitle ="SmartBox management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>
        <?php
            if($_SESSION["userIsAdmin"]==0){

                $sqlStatement = $connection->prepare("SELECT * from smartboxes where UserNo=(select UserNo from users where UserName=?)");
                $sqlStatement->bind_param("s", $_SESSION["currentUser"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();

            }else{
                $result = $connection->query("SELECT * from smartboxes");
            }
             
            if ($result) {

                if(isset($_POST["generateConf"])) { 

                    $sqlSelect = $connection->prepare("SELECT HostName FROM smartboxes WHERE HostName=?");
                    $sqlSelect->bind_param("s", $_POST["generateConf"]);
                    $sqlSelect->execute();
                    $result = $sqlSelect->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);
    
                    header("location: configuration.php?HostName=".$data[0]["HostName"]);
    
                }

                if(isset($_POST["addSwitches"])){
                    $sqlSelect = $connection->prepare("SELECT HostName FROM smartboxes WHERE HostName=?");
                    $sqlSelect->bind_param("s", $_POST["addSwitches"]);
                    $sqlSelect->execute();
                    $result = $sqlSelect->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);
    
                    header("location: switchExecute.php?HostName=".$data[0]["HostName"]);
                }

                if(isset($_POST["deleteSB"])) { //this has to be at the beggining so the refresh works 

                    $sqlDelete = $connection->prepare("DELETE FROM smartboxes where HostName=?");
    
                    if(!$sqlDelete){
                        die("Error: the smartboxes cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("s", $_POST["deleteSB"]);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["descriptionEdit"])){ //update

                    $sqlUpdate = $connection->prepare("UPDATE smartboxes SET `Description`=?, `Location`=?, UserNo=? where HostName=?"); //fine
        
                    if(!$sqlUpdate){
                        die("Error: the smartboxes cannot be updated");
                    }
                    
                    $sqlUpdate->bind_param("ssis", $_POST["descriptionEdit"], $_POST["locationEdit"], $_POST["userNoEdit"], $_POST["hostNameSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
 
                if(!empty($_POST["hostNameCreate"])&&!empty($_POST["descriptionCreate"])&&!empty($_POST["locationCreate"])&&!empty($_POST["userNoCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `smartboxes` (`HostName`, `Description`, `Location`, `UserNo`) VALUES (?,    ?,    ?,    ?)");

                    if(!$sqlCreate){
                        die("Error: the smartboxes cannot be created");
                    }

                    $sqlCreate->bind_param("sssi", $_POST["hostNameCreate"], $_POST["descriptionCreate"], $_POST["locationCreate"], $_POST["userNoCreate"]);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">HostName</th>
                            <th scope="col">Description</th>
                            <th scope="col">Location</th>
                            <th scope="col">UserNo</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["HostName"] ?></th>
                                <td><?= $row["Description"] ?></td>
                                <td><?= $row["Location"] ?></td>
                                <td><?= $row["UserNo"] ?></td>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="generateConf" value="<?= $row["HostName"] ?>">
                                        <input type="submit" value="Generate configuration">
                                    </form>
                                </td>
                                <td>
                                    <div class="mb-3">
                                        <form action="" method="post">
                                            <input type="hidden" name="addSwitches">
                                            <input type="submit" class="btn btn-primary" value="Add Switches"></input>
                                        </form>
                                    </div>
                                </td>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="editSB" value="<?= $row["HostName"] ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="deleteSB" value="<?= $row["HostName"] ?>">
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
    
    if(isset($_POST["editSB"])){

        $sqlSelect = $connection->prepare("SELECT HostName, `Description`, `Location`, UserNo FROM smartboxes WHERE HostName=?");
        $sqlSelect->bind_param("s", $_POST["editSB"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <fieldset disabled>
                <div class=" mb-3">
                    <label for="">HostName</label>
                    <input type="text" id="disabledTextInput" class="form-control" name="hostNameEdit" placeholder="<?= $data[0]["HostName"] ?>">
                </div>
            </fieldset>

            <input type="hidden" class="form-control" name="hostNameSearch" value="<?= $data[0]["HostName"] ?>">

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">Location</label>
                <input type="text" class="form-control" name="locationEdit" value="<?= $data[0]["Location"] ?>">
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
                <input type="hidden" name="createSB">
                <input type="submit" class="btn btn-primary" value="Create"></input>
            </form>
        </div>
<?php
    }
    if(isset($_POST["createSB"])){

        ?>
        <form method="post">

            <div class=" mb-3">
                <label for="">HostName</label>
                <input type="text" class="form-control" name="hostNameCreate" placeholder="SB_#">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionCreate" placeholder="box #">
            </div>

            <div class="form-group mb-3">
                <label for="">Location</label>
                <input type="text" class="form-control" name="locationCreate" placeholder="Country">
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

            <button type="submit" class="btn btn-success">Create a smartboxes</button>

        </form>
        <?php
    }

        ?>
    </body>
</html>
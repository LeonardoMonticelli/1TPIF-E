<?php //head

    $pageTitle ="Events";
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
                header("location: sbManagement.php");
            }

            $sqlStatement = $connection->prepare("SELECT * from events where HostName=?"); 
            
            $sqlStatement->bind_param("s", $_GET["HostName"]);
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

                if(!empty($_POST["descriptionEdit"])){ //update

                    $sqlUpdate = $connection->prepare("UPDATE events SET `HostName`=?, PinNo=?, EventCode=?, `Description`=? where EventId=?"); //fine
        
                    if(!$sqlUpdate){
                        die("Error: the smartboxes cannot be updated");
                    }
                    
                    $sqlUpdate->bind_param("sissi", $_POST["hostNameEdit"], $_POST["pinNoEdit"], $_POST["eventCodeEdit"], $_POST["descriptionEdit"], $_POST["eventIdSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
 
                if(!empty($_POST["descriptionCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `events` (`HostName`, `PinNo`, `EventCode`, `Description`) VALUES (?, ?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the smartboxes cannot be created");
                    }

                    $sqlCreate->bind_param("siss", $_POST["hostNameCreate"], $_POST["pinNoCreate"], $_POST["eventCodeCreate"], $_POST["descriptionCreate"],);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>
                            
                            <th scope="col">EventId</th>
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
                                <td><?= $row["PinNo"] ?></td>
                                <td><?= $row["EventCode"] ?></td>
                                <td><?= $row["Description"] ?></td>
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

        $sqlSelect = $connection->prepare("SELECT * FROM events WHERE EventId=?");
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
                <input type="hidden" class="form-control" name="eventIdSearch" value="<?= $data[0]["EventId"] ?>">
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

            <div class=" mb-3">

                <label for="">PinNo</label>
                <input type="number" class="form-control" name="pinNoEdit" value="<?= $data[0]["PinNo"] ?>">

            </div>

            <div class=" mb-3">

                <label for="">EventCode</label>
                <select name="eventCodeEdit" class="form-select">
                    <option value="K">K</option>
                    <option value="L">L</option>
                </select>

            </div>

            <div class=" mb-3">

                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">

            </div>

            <button type="submit" class="btn btn-success  mb-3">Submit changes</button>

        </form>

        <?php
    }    
?>  
        <div class="mb-3">
            <form action="" method="post">
                <input type="hidden" name="createEvent">
                <input type="submit" class="btn btn-primary" value="Create"></input>
            </form>
        </div>
<?php
    if(isset($_POST["createEvent"])){


        $sqlSelect = $connection->prepare("SELECT * FROM events");

        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post">

        <div class=" mb-3">

            <fieldset disabled>
                <label for="">HostName</label>
                <input type="text" id="disabledTextInput" class="form-control" name="" placeholder="<?= $_GET["HostName"] ?>">
            </fieldset>

            <input type="hidden" class="form-control" name="hostNameCreate" value="<?= $_GET["HostName"] ?>">
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

                <label for="">Event Code</label>
                <select name="eventCodeCreate" id="" class="form-select">

                    <option value="K">K</option>
                    <option value="L">L</option>

                </select>


            </div>

            <div class="form-group mb-3">

                <label for="">Description</label>
                <input type="text" id="" class="form-control" name="descriptionCreate" placeholder="How to activate it">

            </div>

            <button type="submit" class="btn btn-success">Create a Event</button>

        </form>
        <?php
    }
        ?>
    </body>
</html>
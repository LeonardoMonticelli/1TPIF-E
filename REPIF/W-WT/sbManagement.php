<?php //head
    $pageTitle ="SmartBox Management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>

<body>
    <?php
        $result = $connection->query("SELECT * from smartbox");

        if ($result) {

            if(isset($_POST["deleteSB"])) { //this has to be at the beggining so the refresh works 

                $delval = intval($_POST["deleteSB"]);
                $sqlDelete = $connection->prepare("DELETE FROM smartbox where HostName=?");

                if(!$sqlDelete){
                    die("Error: the SB cannot be deleted");
                }
                
                $sqlDelete->bind_param("i", $delval);

                $sqlDelete->execute();

                header("refresh: 0");

            }

            if(!empty($_POST["hostNameEdit"])&&!empty($_POST["descriptionEdit"])&&!empty($_POST["locationEdit"])&&!empty($_POST["userNoEdit"])){ //update

                $sqlUpdate = $connection->prepare("UPDATE smartbox SET HostName=?, PinNo=?, Input=?, Designation=? where HostName=?");
    
                if(!$sqlUpdate){
                    die("Error: the SB cannot be updated");
                }

                $sqlUpdate->bind_param("sssis", $_POST["hostNameEdit"], $_POST["descriptionEdit"], $_POST["locationEdit"], $_POST["userNoEdit"],  $_POST["hostNameEdit"]);
                $sqlUpdate->execute();

                header("refresh: 0");
    
            }

            if(!empty($_POST["createHostname"])&&!empty($_POST["createDescription"])&&!empty($_POST["createLocation"])&&!empty($_POST["createUserNo"])){ //create
                print "your mom";
                $sqlCreate = $connection->prepare("INSERT INTO smartbox(HostName, `Description`, `Location`, UserNo) VALUES (?,?,?,?)");
                
                if(!$sqlCreate){
                    die("Error: the SB cannot be created");
                }

                $sqlCreate->bind_param("sssi", $_POST["createHostname"], $_POST["createDescription"], $_POST["createLocation"], $_POST["createUserNo"]);
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
                        <?php
                        while ($row = $result->fetch_assoc()) {
                        ?>                  
                            <tr>

                                <th scope="row"><?= $row["HostName"] ?></th>
                                <td><?= $row["Description"] ?></td>
                                <td><?= $row["Location"] ?></td>
                                <td><?= $row["UserNo"] ?></td>

                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="editSB" value="<?= $row["HostName"] ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="deleteSB" value="<?= $row["HostName"] ?>">
                                        <input type="submit" value="Remove">
                                    </form>
                                </td>
                            </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>

            <form action="" method="post">
                <input type="hidden" name="createSB">
                <input type="submit" class="btn btn-secondary" value="Create a SmartBox"></button>
            </form>

    <?php
        } //end of the if ($result) 
        
        if(isset($_POST["createSB"])){
    ?>
        <div class="d-flex justify-content-left m-3"> 
            <form method="post">
                <div class="form-group mb-3">
                    <label for="">Hostname</label>
                    <input type="text" class="form-control" name="createHostname" placeholder="SB_0">
                </div>

                <div class="form-group mb-3">
                    <label for="">Description</label>
                    <input type="text" class="form-control" name="createDescription" placeholder="this is box 0">
                </div>

                <div class="form-group mb-3">
                    <label for="">Location</label>
                    <input type="text" class="form-control" name="createLocation" placeholder="Where is the SmartBox located">
                </div>

                <div class="form-group mb-3">
                    <label for="">UserNo</label>

                    <select name="createUserNo" class="form-select">
                        <?php
                            $sqlSelect = $connection->prepare("SELECT UserNo FROM smartbox");
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

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
        <?php
        }
        
        if(isset($_POST["editSB"])){

            $editSbVal = intval($_POST["editSB"]);
            $sqlSelect = $connection->prepare("SELECT HostName, `Description`, `Location`, UserNo FROM smartbox WHERE HostName=?"); //UserNo is FK
            $sqlSelect->bind_param("i", $editSbVal);
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
                    <label for="">Description</label>
                    <input type="text" class="form-control" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="">Location</label>
                    <input type="text" class="form-control" name="locationEdit" value="<?= $data[0]["Location"] ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="">UserNo</label>
                    <input type="text" class="form-control" name="userNoEdit" value="<?= $data[0]["UserNo"] ?>">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        <?php
        }   
    ?>
</body>
</html>
<?php //head
    $pageTitle ="Concern";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
?>
    <body>
        <div>This is where the Groups and Pins are connected</div>
        <?php
        //A button to go back
        // a print that says the changes where made succesfully

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
                        die("Error: the users cannot be updated");
                    }

                    $sqlUpdate->bind_param("isi", $_POST["groupNoEdit"], $_POST["hostNameEdit"], $_POST["pinNoEdit"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
                   
                if(!empty($_POST["groupNoCreate"])&&!empty($_POST["hostNameCreate"])&&!empty($_POST["pinNoCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `groups` (`GroupNo`, `GroupName`, `Description`, `HostName`) VALUES (?, ?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the users cannot be created");
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
        $sqlSelect = $connection->prepare("SELECT ConcernId, GroupNo, HostName, PinNo FROM groups WHERE ConcernId=?");
        $sqlSelect->bind_param("i", $editConVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <div class="form-group mb-3">
                <label for="">ConcernId</label>
                <input type="text" class="form-control" name="concernIdEdit" value="<?= $data[0]["ConcernId"] ?>">
                <input type="hidden" class="form-control" name="concernIdSearch" value="<?= $data[0]["ConcernId"] ?>">
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
                <input type="text" class="form-control" name="hostNameEdit" value="<?= $data[0]["HostName"] ?>">
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

    ?>
        <form method="post">

            <div class="form-group mb-3">
                <label for="">GroupNo</label>
                <input type="text" class="form-control" name="groupNoCreate" placeholder="username">
            </div>

            <div class="form-group mb-3">
                <label for="">GroupName</label>
                <input type="text" class="form-control" name="groupNameCreate" placeholder="first name">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionCreate" placeholder="last name">
            </div>

            <div class="form-group mb-3">
                <label for="">HostName</label>
                <input type="text" class="form-control" name="descriptionCreate" placeholder="111.111.111">
            </div>



            <button type="submit" class="btn btn-success">Create a group</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
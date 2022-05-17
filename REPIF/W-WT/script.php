<?php //head
    $pageTitle ="Script";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>
        <?php

            $result = $connection->query("SELECT * from scripts");
 
            if ($result) {

                if(isset($_POST["deleteScript"])) { //this has to be at the beggining so the refresh works 

                    $sqlDelete = $connection->prepare("DELETE FROM scripts where ScriptId=?");
    
                    if(!$sqlDelete){
                        die("Error: the scripts cannot be deleted");
                    }
    
                    $sqlDelete->bind_param("s", $_POST["deleteScript"]);
                    $sqlDelete->execute();
    
                    header("refresh: 0");
    
                }

                if(!empty($_POST["scriptNameEdit"])&&!empty($_POST["pathEdit"])&&!empty($_POST["descriptionEdit"])){ //update

                    $sqlUpdate = $connection->prepare("UPDATE scripts SET ScriptName=?, `Path`=?, `Description`=? where ScriptId=?");
        
                    if(!$sqlUpdate){
                        die("Error: the scripts cannot be updated");
                    }

                    $sqlUpdate->bind_param("sssi", $_POST["scriptNameEdit"], $_POST["pathEdit"], $_POST["descriptionEdit"], $_POST["scriptIdSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
                   
                if(!empty($_POST["scriptNameCreate"])&&!empty($_POST["pathCreate"])&&!empty($_POST["descriptionCreate"])){ //create 

                    $sqlCreate = $connection->prepare("INSERT INTO `scripts` (`ScriptName`, `Path`, `Description`) VALUES (?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the scripts cannot be created");
                    }

                    $sqlCreate->bind_param("sss",  $_POST["scriptNameCreate"], $_POST["pathCreate"], $_POST["descriptionCreate"]);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">Script ID</th>
                            <th scope="col">Script Name</th>
                            <th scope="col">Path</th>
                            <th scope="col">Description</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["ScriptId"] ?></th>
                                <th><?= $row["ScriptName"] ?></th>
                                <td><?= $row["Path"] ?></td>
                                <td><?= $row["Description"] ?></td>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="editScript" value="<?= $row["ScriptId"] ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="deleteScript" value="<?= $row["ScriptId"] ?>">
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
    
    if(isset($_POST["editScript"])){

        $sqlSelect = $connection->prepare("SELECT * FROM scripts WHERE ScriptId=?");
        $sqlSelect->bind_param("s", $_POST["editScript"]);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <input type="hidden" class="form-control" name="scriptIdSearch" value="<?= $data[0]["ScriptId"] ?>">

            <div class="form-group mb-3">
                <label for="">ScriptName</label>
                <input type="text" class="form-control" name="scriptNameEdit" value="<?= $data[0]["ScriptName"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">Path</label>
                <input type="text" class="form-control" name="pathEdit" value="<?= $data[0]["Path"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionEdit" value="<?= $data[0]["Description"] ?>">
            </div>

            <button type="submit" class="btn btn-success">Submit</button>

        </form>
        <?php
    }    
    if($_SESSION["userIsAdmin"]==1){
        ?>

        <form action="" method="post">  
            <input type="hidden" name="createScript">
            <input type="submit" class="btn btn-primary" value="Create scripts path">
        </form>

<?php
    }
    if(isset($_POST["createScript"])){

    ?>
        <form method="post">

            <div class="form-group mb-3">
                <label for="">ScriptName</label>
                <input type="text" class="form-control" name="scriptNameCreate" placeholder="script">
            </div>

            <div class="form-group mb-3">
                <label for="">Path</label>
                <input type="text" class="form-control" name="pathCreate" placeholder="/home/">
            </div>

            <div class="form-group mb-3">
                <label for="">Description</label>
                <input type="text" class="form-control" name="descriptionCreate" placeholder="describe what the scripts does">
            </div>

            <button type="submit" class="btn btn-success">Create an user</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
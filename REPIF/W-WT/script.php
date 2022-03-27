<?php //head
    $pageTitle ="Administration";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
?>

<body>
    <?php //insert nav bar
        if($_SESSION["isUserLoggedIn"]==false){
            header("Location: index.php");
            exit;
        } else {
            include_once "navigationBar.php";
        }
    ?>
  
<h1>Script</h1>

<?php
    $result = $connection->query("SELECT * from script");

    if($result){?>
            <table class="table">
            <thead>
                <tr>

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

                        <th scope="row"><?= $row["ScriptName"] ?></th>
                        <td><?= $row["Path"] ?></td>
                        <td><?= $row["Description"] ?></td>
                        <td>                                
                            <form method="POST">
                                <input type="hidden" name="editScript" value="<?= $row["ScriptName"] ?>">
                                <input type="submit" value="Edit">
                            </form>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="deleteScript" value="<?= $row["ScriptName"] ?>">
                                <input type="submit" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>

<?php
    } else {
        print "Something went wrong with selecting data";
    }

    if(isset($_POST["ScriptName"], $_POST["Path"], $_POST["Description"])){
        $sqlInsert = $connection->prepare("INSERT INTO Script (ScriptName, Path, Description) values (?,?,?)");
        $sqlInsert->bind_param("sss", $_POST["ScriptName"], $_POST["Path"], $_POST["Description"]);
        $resultOfExecute = $sqlInsert->execute();
        if(!$resultOfExecute){
            print "Adding a new script, failed";
        }
    }
    ?>

    </table>

    <form method="POST">
    Add a New Script: <input name="ScriptName" placeholder="Dimmer">
    <input name="Path" placeholder="/Switch/Dimmer.sh">
    <input name="Description" placeholder="Dim Lamp">
    <input type="submit" value="Add">
    </form>


</body>

</html>
<?php
//create a panel where to put the script, and name the script, and the description will be the content


?>
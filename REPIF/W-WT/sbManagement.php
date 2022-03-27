<?php //head
    $pageTitle ="SmartBox Management";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
?>

<body>
    <?php //insert php
        if($_SESSION["isUserLoggedIn"]==false){
            header("Location: index.php");
            exit;
        } else {
            include_once "navigationBar.php";
        }
    ?>
    <?php
        $result = $connection->query("SELECT * from smartbox");

        if ($result) {
            while ($row = $result->fetch_assoc()) {
    ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">HostName</th>
                            <th scope="col">Description</th>
                            <th scope="col">Location</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>                  
                            <tr>

                                <th scope="row"><?= $row["HostName"] ?></th>
                                <td><?= $row["Description"] ?></td>
                                <td><?= $row["Location"] ?></td>

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
                    </tbody>
                </table>
    <?php 
            }//while ($row = $result->fetch_assoc())

        if(isset($createSB)){
    ?>
        <!-- Form to create a smartbox -->
        <div class="">
            <form method="post">

                <label>HostName</label>
                <input name="hostname">

                <label>Description</label>
                <input name="description">

                <label>Location</label>
                <input type="location">

                <input type="submit" value="Create">

            </form>
        </div>
    <?php
        }//if(isset($createSB))

            if(isset($_POST["deleteSB"])) {

                $delval = intval($_POST["deleteSB"]);
                $sqlDelete = $connection->prepare("DELETE FROM smartbox where HostName=?");

                if(!$sqlDelete){
                    die("Error in sql select statement");
                }
                $sqlDelete->bind_param("i", $delval);

                $sqlDelete->execute();

            }
        }  else {
            print "Something went wrong selecting data";
        }
    ?>
    <div class="d-flex justify-content-left m-3"> 
        <form method="post">
                <div class="form-group">
                    <label for="">Hostname</label>
                    <input type="text" class="form-control" name="createHostname" placeholder="SB_0">
                </div>

            <div class="form-group">
                <label for="">Description</label>
                <input type="text" class="form-control" name="createDescription" placeholder="this is box 0">
            </div>

            <div class="form-group">
                <label for="">Location</label>
                <input type="text" class="form-control" name="createLocation" placeholder="Where is the SmartBox located">
            </div>

            <div class="form-group">
                <label for="">UserNo </label>
                <input type="password" class="form-control" name="newUserNumber" placeholder="User number">
            </div>

            <button type="submit" class="btn btn-primary">Create a new SmartBox</button>
        </form>
    </div>

</body>

<?php
//create, update, delete sbs - in progress

//create: use a form to fill in 

//update: select a smartbox to modify -in progress

//delete: button that deletes the smartbox from the database - in progress

//assign smartboxes to users

//save the configurations/script

?>
</html>
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
            <div class="container">
                <div class="row">

                    <div class="col-md-auto border">
                        <?= $row["HostName"] ?>
                    </div>
                    <div class="col-md-auto border">
                        <?= $row["Description"] ?>
                    </div>
                    <div class="col-md-auto border">
                        <?= $row["Location"] ?>
                    </div>
                    <div class="col-md-auto border">
                        <form method="POST">
                            <input type="hidden" name="editSB" value="<?= $row["HostName"] ?>">
                            <input type="submit" value="Edit">
                        </form>
                    </div>
                    <div class="col-md-auto border">
                        <form method="POST">
                            <input type="hidden" name="deleteSB" value="<?= $row["HostName"] ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </div>
                </div>
            </div>
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

</body>

<?php
//create, update, delete sbs 

//create: use a form to fill in

//select: select a sb from a scrollabe list

//update: select a smartbox to modify

//delete: button that deletes the smartbox from the database

//assign smartboxes to users

//PINS define inputs and outputs

//save the configurations

?>
</html>
<?php //head
    $pageTitle ="Pin management";
    include_once "htmlHead.php";
    include_once "connectToDB.php";
    include_once "sessionCheck.php";
?>
    <body>
        <?php
            if($_SESSION['isUserLoggedIn']==true){
                include_once "navigationBar.php";
            }

            $result = $connection->query("SELECT * from Pin");

            if ($result) {

                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="container">
                        <div class="row">

                            <div class="col-md-auto border">
                                <?= $row["HostName"] ?>
                            </div>
                            <div class="col-md-auto border">
                                <?= $row["PinNo"] ?>
                            </div>
                            <div class="col-md-auto border">
                                <?= $row["Input"] ?>
                            </div>
                            <div class="col-md-auto border">
                                <?= $row["Designation"] ?>
                            </div>
                            <div class="col-md-auto border">
                                <form method="POST">
                                    <input type="hidden" name="editPin" value="<?= $row["PinNo"] ?>">
                                    <input type="submit" value="Edit">
                                </form>
                            </div>
                            <div class="col-md-auto border">
                                <form method="POST">
                                    <input type="hidden" name="deletePin" value="<?= $row["PinNo"] ?>">
                                    <input type="submit" value="Remove">
                                </form>
                            </div>
                        </div>
                    </div>
        <?php
                }
                if(isset($_POST["deletePin"])) {
                    $delval = intval($_POST["deletePin"]);
                    $sqlDelete = $connection->prepare("DELETE FROM concern where PinNo=?");
                    if(!$sqlDelete){
                        die("Error in sql select statement");
                    }
                    $sqlDelete->bind_param("i", $delval);
                    $sqlDelete->execute();

                    $sqlDelete2 = $connection->prepare("DELETE from Pin where PinNo=?");
                    if(!$sqlDelete2){
                        die("Error in sql select statement");
                    }
                    $sqlDelete2->bind_param("i", $delval);
                    $sqlDelete2->execute();
                }
            }  else {
                print "Something went wrong selecting data";
            }
        ?>
    </body>
</html>

<!-- SELECT * FROM Script s LEFT JOIN `use` u ON s.ScriptName = u.ScriptName LEFT JOIN `group` g ON g.GroupNo = u.GroupNo LEFT JOIN `SmartBox` b ON b.HostName = g.HostName; -->
<?php //head
    $pageTitle ="Event management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>

        <?php
        
            if(isset($_POST["viewEvents"])){ //redirect to the pin Management 

                $sqlSelect = $connection->prepare("SELECT HostName FROM events WHERE HostName=?");
                $sqlSelect->bind_param("s", $_POST["viewEvents"]);
                $sqlSelect->execute();
                $result = $sqlSelect->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);

                header("location: pinManagement.php?HostName=".$data[0]["HostName"]);
            }

            if($_SESSION["userIsAdmin"]==0){

                $sqlStatement = $connection->prepare("SELECT events.HostName from events, manage where events.HostName=manage.HostName and manage.UserNo=?");
                $sqlStatement->bind_param("i", $_SESSION["currentUserNo"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();

            }else{
                $result = $connection->query("SELECT HostName from events ");
            }

            if ($result) {            
                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">HostName</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["HostName"] ?></th>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="viewEvents" value="<?= $row["HostName"] ?>">
                                        <input type="submit" value="View events">
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
    
?>
    </body>
</html>
<?php //head
    $pageTitle ="Pin management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>

        <?php
        
            if(isset($_POST["viewPins"])){ //redirect to the pin Management 

                $sqlSelect = $connection->prepare("SELECT HostName FROM pins WHERE HostName=?");
                $sqlSelect->bind_param("s", $_POST["viewPins"]);
                $sqlSelect->execute();
                $result = $sqlSelect->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);

                // var_dump($data[0]["HostName"]);
                header("location: pinManagement.php?HostName=".$data[0]["HostName"]);
            }

            if($_SESSION["userIsAdmin"]==0){

                $sqlStatement = $connection->prepare("SELECT HostName from pins, manage where pins.HostName=manage.HostName and manage.UserNo=? GROUP BY HostName HAVING COUNT(*) > 1");
                $sqlStatement->bind_param("i", $_SESSION["currentUserNo"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();

            }else{
                $result = $connection->query("SELECT HostName from pins GROUP BY HostName HAVING COUNT(*) > 1");
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
                                        <input type="hidden" name="viewPins" value="<?= $row["HostName"] ?>">
                                        <input type="submit" value="View Pins">
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
<?php //head
    $pageTitle ="users management";
    include_once "htmlHead.php";
    include_once "databaseConnect.php";
    include_once "sessionCheck.php";
    include_once "navigationBar.php";
?>
    <body>
        <?php
            //if I am # users then dispplay the rows that below to the same userNo
            if($_SESSION["userIsAdmin"]==0){

                $sqlStatement = $connection->prepare("SELECT * from users where UserNo=(select UserNo from users where UserName=?)");
                $sqlStatement->bind_param("s", $_SESSION["currentUser"]);
                $sqlStatement->execute();

                $result = $sqlStatement->get_result();

            }else{
                $result = $connection->query("SELECT * from users");
            }
 
            if ($result) {

                if(isset($_POST["deleteUser"])) { //this has to be at the beggining so the refresh works 

                    if($_SESSION["currentUserNo"]==$_POST["deleteUser"]){
                        ?>
                        <script>alert("you can't delete your own user!");</script>
                        <?php
                    } else {

                        $deleteUserVal = intval($_POST["deleteUser"]);
                        $sqlDelete = $connection->prepare("DELETE FROM users where UserNo=?");
        
                        if(!$sqlDelete){
                            die("Error: the users cannot be deleted");
                        }
        
                        $sqlDelete->bind_param("i", $deleteUserVal);
                        $sqlDelete->execute();
        
                        header("refresh: 0");

                    }

                }

                if(!empty($_POST["userNameEdit"])&&!empty($_POST["firstNameEdit"])&&!empty($_POST["lastNameEdit"])&&!empty($_POST["emailEdit"])){ //update

                    $sqlUpdate = $connection->prepare("UPDATE users SET UserName=?, FirstName=?, LastName=?, `Technician`=?, Email=? where UserNo=?");
        
                    if(!$sqlUpdate){
                        die("Error: the users cannot be updated");
                    }

                    $sqlUpdate->bind_param("sssisi", $_POST["userNameEdit"], $_POST["firstNameEdit"], $_POST["lastNameEdit"], $_POST["technicianEdit"], $_POST["emailEdit"], $_POST["userNoSearch"]);
                    $sqlUpdate->execute();

                    header("refresh: 0");
        
                }
                   
                if(!empty($_POST["userNameCreate"])&&!empty($_POST["firstNameCreate"])&&!empty($_POST["lastNameCreate"])&&!empty($_POST["emailCreate"])&&!empty($_POST["passwordCreate"])){ //create 

                    $password = $_POST['passwordCreate'];

                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $sqlCreate = $connection->prepare("INSERT INTO `users` (`UserName`, `FirstName`, `LastName`, `Technician`, `Email`, `Password`) VALUES (?, ?, ?, ?, ?, ?)");

                    if(!$sqlCreate){
                        die("Error: the users cannot be created");
                    }

                    $sqlCreate->bind_param("sssiss",  $_POST["userNameCreate"], $_POST["firstNameCreate"], $_POST["lastNameCreate"], $_POST["technicianCreate"], $_POST["emailCreate"], $hashedPassword);
                    $sqlCreate->execute();

                    header("refresh: 0");
                }

                ?>
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">UserNo</th>
                            <th scope="col">UserName</th>
                            <th scope="col">FirstName</th>
                            <th scope="col">LastName</th>
                            <th scope="col">Technician</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        while ($row = $result->fetch_assoc()) {?>                           
                            <tr>

                                <th scope="row"><?= $row["UserNo"] ?></th>
                                <td><?= $row["UserName"] ?></td>
                                <td><?= $row["FirstName"] ?></td>
                                <td><?= $row["LastName"] ?></td>
                                <td><?= $row["Technician"] ?></td>
                                <td><?= $row["Email"] ?></td>
                                <td>                                
                                    <form method="POST">
                                        <input type="hidden" name="editUser" value="<?= $row["UserNo"] ?>">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                                <?php if($_SESSION["userIsAdmin"]==1){?>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="deleteUser" value="<?= $row["UserNo"] ?>">
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
    
    if(isset($_POST["editUser"])){

        $editUserVal = intval($_POST["editUser"]);
        $sqlSelect = $connection->prepare("SELECT UserNo, UserName, FirstName, LastName, Technician, `Email` FROM users WHERE UserNo=?");
        $sqlSelect->bind_param("i", $editUserVal);
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        ?>
        <form method="post" class="mb-3">

            <fieldset disabled>
                <div class="form-group mb-3">
                    <label for="">UserNo</label>
                    <input type="text" class="form-control" name="" value="<?= $data[0]["UserNo"] ?>">
                </div>
            </fieldset>
            
            <input type="hidden" class="form-control" name="userNoSearch" value="<?= $data[0]["UserNo"] ?>">

            <div class="form-group mb-3">
                <label for="">UserName</label>
                <input type="text" class="form-control" name="userNameEdit" value="<?= $data[0]["UserName"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">FirstName</label>
                <input type="text" class="form-control" name="firstNameEdit" value="<?= $data[0]["FirstName"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">LastName</label>
                <input type="text" class="form-control" name="lastNameEdit" value="<?= $data[0]["LastName"] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="">Techinician</label>

                <select name="technicianEdit" class="form-select">
                    <?php
                        $sqlSelect = $connection->prepare("SELECT Technician FROM users");
                        $sqlSelect->execute();
                        $result = $sqlSelect->get_result();

                        while($row = $result->fetch_assoc()){
                            ?>
                            <option <?php if($data[0]["Technician"]==$row["Technician"]){print " selected ";}?>value="<?=$row["Technician"]?>"><?= $row["Technician"]?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="text" class="form-control" name="emailEdit" value="<?= $data[0]["Email"] ?>">
            </div>

            <button type="submit" class="btn btn-success">Submit</button>

        </form>
        <?php
    }    
    if($_SESSION["userIsAdmin"]==1){
        ?>

        <form action="" method="post">  
            <input type="hidden" name="createUser">
            <input type="submit" class="btn btn-primary" value="Create">
        </form>

<?php
    }
    if(isset($_POST["createUser"])){

    ?>
        <form method="post">

            <div class="form-group mb-3">
                <label for="">UserName</label>
                <input type="text" class="form-control" name="userNameCreate" placeholder="username">
            </div>

            <div class="form-group mb-3">
                <label for="">FirstName</label>
                <input type="text" class="form-control" name="firstNameCreate" placeholder="first name">
            </div>

            <div class="form-group mb-3">
                <label for="">LastName</label>
                <input type="text" class="form-control" name="lastNameCreate" placeholder="last name">
            </div>

            <div class="form-group mb-3">
                <label for="">Technician</label>
                <select name="technicianCreate" id="">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="email" class="form-control" name="emailCreate" placeholder="example@example.com">
            </div>

            <div class="form-group mb-3">
                <label for="">Password</label>
                <input type="password" class="form-control" name="passwordCreate" placeholder="please type a password">
            </div>

            <button type="submit" class="btn btn-success">Create an user</button>

        </form>
    <?php
    }
    ?>
    </body>
</html>
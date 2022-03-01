<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Signup</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <script src=''></script>
</head>
<body>
    <?php
        include_once "navBar.php";
        include_once "dbConnect.php";

        if (isset($_POST["FirstName"],$_POST["LastName"],$_POST["UserName"],$_POST["Password"],$_POST["Password2"])){
                echo "We are signing you up!<br>";

                if ($_POST["Password"] == $_POST["Password2"]) {        
                    $sql = $connection->prepare("INSERT INTO PEOPLE(FName, LName, UsrName, Psw, C_ID, UserRole) VALUES(?,?,?,?,?,?)");
        
                    if (!$sql) {
                        echo "Error in your sql<br>";
                    }
        
                    $hashedPassword = password_hash($_POST["Password"], PASSWORD_BCRYPT);
                    $user = "user";
        
                    $sql->bind_param(
                        "ssssis",
                        $_POST["FirstName"],
                        $_POST["LastName"],
                        $_POST["UserName"],
                        $hashedPassword,
                        $_POST["Country"],
                        $user
                    );
        
                    $SQLexecute = $sql->execute();
                    if (!$SQLexecute) {
                        echo 'Problem running SQLexecute. <br>';
                        echo $sql->error;
                    } else {
                        echo "You are signed up. Please check the database!<br>";
                    }
                } else {
                    echo "Passwords do not match.<br>";
                }
            }
            ?>
            <h1>Welcome to our page. You will signup here</h1>
            <div class="">
                <form class="myRegistration" method="POST">
                    <label for="FirstName">First Name</label> <input name="FirstName">
                    <label for="LastName">Last Name</label> <input name="LastName">
                    <label for="UserName">Username</label> <input name="UserName">
                    <label for="Psw">Password</label> <input name="Password" type="password">
                    <label for="Psw2">Re-type Password</label> <input name="Password2" type="password">
        
                    <label for="Country">Choose your country of origin:</label>
                    <select name="Country">
                        <?php
                        $sqlSelect = $connection->prepare("SELECT * from COUNTRIES");
                        $selectionWentOK = $sqlSelect->execute();
        
                        if ($selectionWentOK) {
                            $result = $sqlSelect->get_result();
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <option value="<?= $row["C_ID"] ?>"><?= $row["C_Name"] ?></option>
                        <?php
                            }
                        } else {
                            echo "Something went wrong when selecting data";
                        }
                        ?>
                    </select>
        
                    <input type="submit" name="submit">
                </form>
</body>
</html>
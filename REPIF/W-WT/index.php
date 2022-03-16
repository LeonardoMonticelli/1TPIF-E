<?php //connect to the DB
    $dbHost="localhost";
    $dbUser="root";
    $dbPassword="";
    $dbName="WT";

    $conn= new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }
?>

<?php //head
    $pageTitle ="Homepage";
    include_once "htmlHead.php";
?>

<body>
    <?php //insert php
        include_once "sessionCheck.php";
        include_once "navigationBar.php";
    ?>
</body>

</html>
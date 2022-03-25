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
    <div class="scrollable">
        
    </div>
</body>

<?php
//create, update, delete sbs 

//create: use a form to fill in

//select: select a sb from a scrollabe list

//update: select a smartbox to modify

//delete: button that deletes the smartbox from the database

//assign smartboxes to users

//define inputs and outputs

//save the configurations

?>
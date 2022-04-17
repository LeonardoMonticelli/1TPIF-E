<?php

    session_unset();
    session_destroy();
    $_SESSION["isUserLoggedIn"] = false;
    header("Location: index.php");
    exit;

?>
<?php
require("includes/db.php");
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    die();
}
$updated = false;
if(!isset($_GET["id"])) {
    header("Location: index.php");
    die();
}

foreach($_POST as $key => $value) {
    if(strpos($key, "ledaction_") !== false && $value != "IGNORE") {
        $updated = true;
        $pinid = intval(substr($key, strlen("ledaction_")));
        $groupId = intval($_GET["id"]);

        $stmt = $conn->prepare("DELETE FROM boxleds WHERE pinid = :id AND groupid = :groupid");
        $stmt->bindParam(":id", $pinid, PDO::PARAM_INT);
        $stmt->bindParam(":groupid", $groupId);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO boxleds (pinid, groupid, action) VALUES (:pinid, :groupid, :action)");
        $stmt->bindParam(":pinid", $pinid);
        $stmt->bindParam(":groupid", $groupId);
        $stmt->bindParam(":action", $value);
        $stmt->execute();
    }
}
$deleted = false;
if(isset($_POST["reset"])) {
    $stmt = $conn->prepare("DELETE FROM boxleds WHERE groupid = :groupid");
    $gid = intval($_GET["id"]);
    $stmt->bindParam(":groupid", $gid);
    $stmt->execute();
    $deleted = true;
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Korvin Repif</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <!-- Bulma Version 0.7.2-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>

<body>

    <!-- START NAV -->
    <nav class="navbar is-white">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item brand-text" href="../">
                    Korvin Repif
                </a>
                <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAV -->
    <div class="container">
        <?php
        if ($updated == true) {
            echo "<div class='notification is-success'>The LED Settings have been updated</div>";
        }
        ?>
        <?php
        if ($deleted == true) {
            echo "<div class='notification is-danger'>The LED Settings have been reset</div>";
        }
        ?>
        <div class="columns">
            <div class="column is-3 ">
                <aside class="menu is-hidden-mobile">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li><a class="is-active" href="home.php">SmartBoxes</a></li>
                        <li><a>Change Password</a></li>
                    </ul>
                    <p class="menu-label">
                        Administration
                    </p>
                    <ul class="menu-list">
                        <li><a>Manage Users</a></li>
                        <li><a>Manage Scripts</a></li>
                    </ul>
                </aside>
            </div>
            <div class="column is-9">
                <section class="hero is-info welcome is-small">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Editing LEDs for Group#<?= $_GET["id"] ?>.
                            </h1>
                        </div>
                    </div>
                </section>
                <div class="columns">
                    <div class="column is-12">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Groups 
                                    <form method="post">
                                        <input class="button is-warning" type="submit" name="reset" value="Reset">
                                    </form>
                                </p>
                            </header>
                            <div class="card-table">
                                <div class="content">
                                    <form method="post">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Pin id</th>
                                                    <th>&nbsp;</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Pin id</th>
                                                    <th></th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $ledIds = [7, 8, 12, 13, 16, 19, 20, 21, 26];
                                                foreach($ledIds as &$led) {
                                                    echo "<tr><td>" . $led . "</td><td>&nbsp;</td><td>
                                                    <select name='ledaction_" . $led . "'>
                                                    <option value='IGNORE' selected>Ignore</option>
                                                    <option>ON</option>
                                                    <option>OFF</option>
                                                    <option>TOGGLE</option>
                                                    <option>PULSE</option>
                                                    <option>BLINK</option>
                                                    </select>
                                                    </td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="field">
                                            <div class="control">
                                                <input class="button is-primary" type="submit" value="Create" name="saveLEDs">
                                            </div>
                                        </div>
                                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script async type="text/javascript" src="../js/bulma.js"></script>
</body>

</html>
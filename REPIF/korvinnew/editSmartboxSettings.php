<?php
require("includes/db.php");
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    die();
}

$delete = false;
if (isset($_GET["HostName"]) && $_SESSION["user"]["technician"] == false) {
    $stmt = $conn->prepare("SELECT * FROM smartbox WHERE userId = :userId");
    $stmt->bindParam(":userId", $_SESSION["user"]["id"]);
    $stmt->execute();
    if ($smt->rowCount() == 0) {
        header("Location: home.php");
        die();
    }
}

if(isset($_POST["createGroup"])) {
    $stmt = $conn->prepare("INSERT INTO boxgroups (gname, gdesc, hostname) VALUES (:gname, :gdesc, :ghost)");
    $stmt->bindParam(":gname", $_POST["GroupName"]);
    $stmt->bindParam(":gdesc", $_POST["GroupDesc"]);
    $stmt->bindParam(":ghost", $_GET["id"]);
    $stmt->execute();
}

if(isset($_GET["delid"])) {
    $stmt = $conn->prepare("DELETE FROM boxgroups WHERE id = :gid");
    $stmt->bindParam(":gid", $_GET["delid"]);
    $stmt->execute();
    $delete = true;
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
        if ($delete == true) {
            echo "<div class='notification is-danger'>The group has been deleted.</div>";
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
                                Editing, Box#<?= $_GET["id"] ?>.
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
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                                    <span class="icon">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </header>
                            <div class="card-table">
                                <div class="content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>GroupName</th>
                                                <th>GroupDesc</th>
                                                <th>Settings</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>GroupName</th>
                                                <th>GroupDesc</th>
                                                <th>Settings</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM boxgroups WHERE hostname = :hostname");
                                            $stmt->bindParam(":hostname", $_GET["id"]);
                                            $stmt->execute();
                                            $groups = $stmt->fetchAll();
                                            foreach ($groups as $group) {
                                                echo "<tr>";
                                                echo "<td>" . $group["gname"] . "</td>";
                                                echo "<td>" . $group["gdesc"] . "</td>";
                                                echo "<td>
                                                    <a href='editLEDSettings.php?id=" . $group["id"] . "' class='button is-small is-primary'>Setup</a>
                                                    <a href='editSmartboxSettings.php?id=" . $_GET["id"] . "&delid=" . $group["id"] . "' class='button is-small is-danger'>Delete</a>
                                                </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <hr />
                                    <h2 class="subtitle">Add Group</h2>
                                    <form method="post">

                                        <div class="field">
                                            <label class="label">GroupName</label>
                                            <div class="control">
                                                <input class="input" type="text" placeholder="Kitchen Group..." name="GroupName">
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="label">GroupDesc</label>
                                            <div class="control">
                                                <input class="input" type="text" placeholder="Turns on lights in the kitchen..." name="GroupDesc">
                                            </div>
                                        </div>

                                        
                                        <input type="hidden" name="GroupHost" value="<?= $_GET["id"] ?>" />

                                        <div class="field">
                                            <div class="control">
                                                <input class="button is-primary" type="submit" value="Create" name="createGroup">
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
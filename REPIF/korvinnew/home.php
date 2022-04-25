<?php
require("includes/db.php");
session_start();
if(!isset($_SESSION["user"])) {
    header("Location: index.php");
    die();
}

$delete = false;
if(isset($_GET["delid"])) {
    $delid = $_GET["delid"];
    $stmt = $conn->prepare("DELETE FROM smartboxes WHERE HostName = :hostname");
    $stmt->bindParam(":hostname", $delid);
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
    if($delete == true) {
        echo "<div class='notification is-danger'>The box has been deleted.</div>";
    }
    ?>
        <div class="columns">
            <div class="column is-3 ">
                <aside class="menu is-hidden-mobile">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li><a class="is-active">SmartBoxes</a></li>
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
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="../">Bulma</a></li>
                        <li><a href="../">Templates</a></li>
                        <li><a href="../">Examples</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Admin</a></li>
                    </ul>
                </nav>
                <section class="hero is-info welcome is-small">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Hello, Admin.
                            </h1>
                            <h2 class="subtitle">
                                I hope you are having a great day!
                            </h2>
                        </div>
                    </div>
                </section>
                <div class="columns">
                    <div class="column is-12">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Events
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
                                                <th>HostName</th>
                                                <th>Description</th>
                                                <th>Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>HostName</th>
                                                <th>Description</th>
                                                <th>Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            if($_SESSION["user"]["technician"] == true) {
                                                $stmt = $conn->prepare("SELECT * FROM smartboxes");
                                                $stmt->execute();
                                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($result as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["HostName"] . "</td>";
                                                    echo "<td>" . $row["Description"] . "</td>";
                                                    echo "<td>" . $row["Location"] . "</td>";
                                                    echo "<td>";
                                                    echo "<a class='button is-small is-primary' href='editSmartboxSettings.php?id=" . $row["HostName"] . "'>Edit</a>";
                                                    echo "<a class='button is-small is-danger' href='home.php?delid=" . $row["HostName"] . "'>Delete</a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                $stmt = $conn->prepare("SELECT * FROM smartboxes WHERE userId = :userId");
                                                $stmt->bindParam(":userId", $_SESSION["user"]["id"]);
                                                $stmt->execute();
                                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($result as $row) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["HostName"] . "</td>";
                                                    echo "<td>" . $row["Description"] . "</td>";
                                                    echo "<td>" . $row["Location"] . "</td>";
                                                    echo "<td>";
                                                    echo "<a class='button is-small is-primary' href='editSmartboxSettings.php?id=" . $row["HostName"] . "'>Edit</a>";
                                                    echo "<a class='button is-small is-danger' href='home.php?delid=" . $row["HostName"] . "'>Delete</a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
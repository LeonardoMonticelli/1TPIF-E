<?php
session_start();
require("includes/db.php");

if(isset($_SESSION["user"])) {
    header("Location: home.php");
    die();
}

$emsg = "";

if(isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if($stmt->rowCount() == 1) {
        if(password_verify($password, $user["pwd"])) {
            $_SESSION["user"] = $user;
            header("Location: home.php");
            exit();
        } else {
            $emsg = "Invalid password";
        }
    } else {
        $emsg = "Invalid username";
    }
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
    if(!empty($emsg)) {
        echo "<div class='notification is-danger'>$emsg</div>";
    }
    ?>
        <div class="columns">
            <div class="column is-3 ">
                <aside class="menu is-hidden-mobile">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li><a class="is-active">Login</a></li>
                    </ul>
                </aside>
            </div>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                    </ul>
                </nav>
                <section class="hero is-info welcome is-small">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Hello, Guest.
                            </h1>
                            <h2 class="subtitle">
                                Please log in
                            </h2>
                        </div>
                    </div>
                </section>
                <section class="info-tiles">
                    <div class="tile is-ancestor has-text-centered">
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="content">
                                            <form method="post">
                                                <div class="field">
                                                    <label class="label">Username</label>
                                                    <div class="control">
                                                        <input class="input" type="text" placeholder="Username" name="username">
                                                    </div>
                                                </div>


                                                <div class="field">
                                                    <label class="label">Password</label>
                                                    <div class="control">
                                                        <input class="input" type="password" placeholder="Password" name="password">
                                                    </div>
                                                </div>

                                                <div class="field is-grouped">
                                                    <div class="control">
                                                        <button class="button is-link">Submit</button>
                                                    </div>
                                                    <div class="control">
                                                        <button class="button is-link is-light">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    <script async type="text/javascript" src="../js/bulma.js"></script>
</body>

</html>
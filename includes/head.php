<?php
ob_start();
require "dbcon.php";
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Set Sail for New Horizons! </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <!-- <title>Home page</title> -->

    <!-- css -->

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="theme-color" content="#712cf9">
    <link rel="icon" href="../pictures/favicon (1).ico">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.14.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Styles/main.css">
    <!--   bootstrap fonts -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!--   CSS fonts -->
    <link rel="stylesheet" href="../styles/main.css">

    <!--   Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&family=Ubuntu:wght@300&display=swap" rel="stylesheet">

    <!--   Awesome fonts -->
    <script src="https://kit.fontawesome.com/de7c5bb96e.js" crossorigin="anonymous"></script>

    <link rel="icon" href="../pictures/favicon (1).ico">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sunstruck Sails</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <a class="nav-link active" href="index.php#booktrip">Book Your Journey</a>
                </ul>
                <ul class="navbar-nav">
                    <a class="nav-link active" href="index.php#boats">Our Vessels</a>
                </ul>
                <ul class="navbar-nav">
                    <a class="nav-link active " href="index.php#trips">Explore Trips</a>
                </ul>
                <ul class="navbar-nav">
                    <a class="nav-link active " href="contact.php">Get in Touch</a>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>

                    <?php if (isset($_SESSION['username'])) {
                        if ($_SESSION['role'] === 'admin') {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="./admin/index.php">Administrator</a>
                            </li>
                    <?php }
                    } ?>

                    <?php if (!isset($_SESSION['username'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="login.php">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="signup.php">Sign Up</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['firstname']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link profile-link" href="profile.php">
                                        <i class="fas fa-user"></i> Your Profile
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>

    <div class="container marketing">

    </div>
</body>

</html>
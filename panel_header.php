<?php
// Initialize the session
session_start();

?>

<!doctype html>
<html lang="fr">

<head>
    <script src="/assets/js/bootstrap.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <title>Projet PHP<?php if (isset($_SESSION["role"])) {echo " - ".ucfirst($_SESSION["role"]);}?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="/assets/css/signin.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">

</head>

<body class="text-center">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary blue">
        <a class="navbar-brand" href="index.php">Projet PHP<?php if (isset($_SESSION["role"])) {echo " - ".ucfirst($_SESSION["role"]);}?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">

                    <?php
if (isset($_SESSION["role"])) {
                        echo"
                        <li class=\"nav-item\">
                        <a href=\"../logout.php\" class=\"btn btn-outline-light my-2 my-sm-0\" role=\"button\" aria-disabled=\"true\">Déconnexion</a>
                        </li>";
}
?>
        </div>
    </nav>
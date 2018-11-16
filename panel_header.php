<?php
// Initialize the session
session_start();

?>

<!doctype html>
<html lang="fr">

<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://projet.thomaslacaze.fr/assets/js/bootstrap.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <title>Projet PHP</title>

    <!-- Bootstrap core CSS -->
    <link href="https://projet.thomaslacaze.fr/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://projet.thomaslacaze.fr/assets/css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="https://projet.thomaslacaze.fr/assets/css/signin.css" rel="stylesheet">
    <link href="https://projet.thomaslacaze.fr/assets/css/custom.css" rel="stylesheet">

</head>

<body class="text-center">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary blue">
        <a class="navbar-brand" href="index.php">Projet PHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">

                    <?php
if (isset($_SESSION["role"])) {
    echo "<a class=\"nav-link dropdown-toggle";
    echo "\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                        " . htmlspecialchars($_SESSION["role"]) . "</a>
                    <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                        <a class=\"dropdown-item\" href=\"../logout.php\">Deconnexion</a>
                    </div>";
} else {
    echo "<li class=\"nav-item\">
                    <a href=\"index.php?1\" class=\"nav-link\">Connexion</a>
                    </li>";
}
?>
                </li>
                <li class="nav-item">
                <a href="contact.php" class="nav-link">Contactez-nous</a>
                </li>
        </div>
    </nav>
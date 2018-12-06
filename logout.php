<?php
  session_start(); //On démarre la session
  $_SESSION = array(); //On supprime toutes les variables qu'on a pu écrire en mettant un tableau vide
  unset($_SESSION);
  session_unset(); //Pas très important mais au cas où
  session_destroy(); //On détruit la session
  header('Location: index.php');
?>
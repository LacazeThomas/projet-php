<?php
session_start();

if ($_SESSION["role"] == "edt"){
	$vote = array($_POST["ue1"],$_POST["ue2"],$_POST["ue3"],$_POST["ue4"],$_POST["ue5"]);

	$fp =  fopen("votes/vote-".$_SESSION["id"].".csv", "w");

	fputcsv($fp, $vote, ",");

	fclose($fp);
	}

header('Location: index.php');
?>
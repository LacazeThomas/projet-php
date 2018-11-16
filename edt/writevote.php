<<<<<<< HEAD
<?php
session_start();

$tabue = array("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
$tabvotes = array();

foreach ($tabue as $ue){
	if (isset($_POST[$ue])){
		array_push($tabvotes,$_POST[$ue]);
	}
}
if ($_SESSION["role"] == "edt"){
	
	$fp =  fopen("votes/vote-".$_SESSION["id"].".csv", "w");
	
	fputcsv($fp, $tabvotes, ",");

	fclose($fp);
	}

header('Location: index.php');
=======
<?php
require('../header.php')
?>

<?php
session_start();

$tabue = array("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
$tabvotes = array();

foreach ($tabue as $ue){
	if (isset($_POST[$ue])){
		array_push($tabvotes,$_POST[$ue]);
	}
}
if ($_SESSION["role"] == "edt"){
	
	$fp =  fopen("votes/vote-".$_SESSION["id"].".csv", "w");
	
	fputcsv($fp, $tabvotes, ",");

	fclose($fp);
	}

header('Location: index.php');
>>>>>>> a04b2ed1a6bbe3f1758bf74ddd7ad251c4d9e6aa
?>
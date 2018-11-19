<?php
session_start();

$tabue = array("Mathématiques","Anglais","Programmation","Algorithmique","Economie");

function verif_post($tabue){
	for($i = 0; $i < 5; ++$i){
		if (isset($_POST[$tabue[$i]])){
			$_POST[$tabue[$i]] = intval($_POST[$tabue[$i]]); // Transformation en int
			echo $_POST[$tabue[$i]]."<br/>";
			if ($_POST[$tabue[$i]]<1 or $_POST[$tabue[$i]]>5){
				$_SESSION["error"] = "Les valeurs entrées sont incorrectes";
			}
		}else{
			$_SESSION["error"] = "Pas de valeurs entrées";
		}
	}
}
if(isset($_SESSION['id'])){
	if ($_SESSION['role'] == "edt"){
		verif_post($tabue);
		if (!isset($_SESSION["error"])){
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
		}else{
			header("Location: index.php");
		}
	}
}
header('Location: index.php');

?>
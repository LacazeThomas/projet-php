<html>
<head>
<?php
require('../header.php')
?>
<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
<?php
session_start();

$tabue = array("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
$tabnote = array("Très mécontent","Mécontent","Moyen","Satisfait","Très satisfait");

if ($_SESSION["role"] == "edt"){
    echo $_SESSION["id"];
	$vote = "votes/vote-".$_SESSION["id"].".csv";
	if (file_exists ($vote)){ //Si l'étudiant a voté
		$row = 1;
		if (($handle = fopen($vote, "r")) !== FALSE) {
			while (($note = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($note);
				if($num == 5){
					echo "<h3> Vous avez déjà voté : <br /></h3>\n";
					$row++;
					echo "<table class='table'>";
					for ($c=0; $c < $num; $c++) {
						echo "<tr><th scope='row'>". $tabue[$c] . "</th><td>" . $tabnote[$c] . "</td></tr>";
					}
					echo "</table>";
				}
			}
			fclose($handle);
		}
	}else{
		print('
		<h2 class="title">Formulaire de vote</h2>
		<form method="POST" action="writevote.php">
			<table class="table">');
			foreach ($tabue as $ue){
				
				echo "<tr><th scope='row'>" . $ue . "</th>" ;
				echo "<td><select name=" . $ue . " class = 'chosen-value'>";
				print('
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3" selected>Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select></td>
				</tr>');
			}
		print('
				<tr><td colspan="2"><center><button class="btn btn-outline-success" type="submit">Valider</button></center></tr></td>
			</table>
		</form>');
	}
	
}else{
    header('Location: login.php');  
}
?>
</body>
</html>
<br/>
<form action="../logout.php" method="post">
 <p><button type="submit" class="btn btn-outline-secondary btn-lg" name="submit" value="Déconnexion">Déconnexion</button></p>
</form>
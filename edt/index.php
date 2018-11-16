<<<<<<< HEAD
=======
<html>
<head>
<?php
require('../header.php')
?>
<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
>>>>>>> a04b2ed1a6bbe3f1758bf74ddd7ad251c4d9e6aa
<?php
require_once '../panel_header.php';

$tabue = array("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
$tabnote = array("Très mécontent","Mécontent","Moyen","Satisfait","Très satisfait");

if ($_SESSION["role"] == "edt"){
	$vote = "votes/vote-".$_SESSION["id"].".csv";
	if (file_exists ($vote)){ //Si l'étudiant a voté
		$row = 1;
		if (($handle = fopen($vote, "r")) !== FALSE) {
			while (($note = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($note);
				if($num == 5){
					echo "<h3> Vous avez déjà voté :</h3>\n";
					$row++;
<<<<<<< HEAD
					echo "<table class='table'><tbody>";
					for ($c=0; $c < $num; $c++) {
						echo "<tr><td><strong>" . $tabue[$c] . "</strong></td><td>" . $tabnote[$note[$c]-1] . "</td></tr>";
=======
					echo "<table class='table'>";
					for ($c=0; $c < $num; $c++) {
						echo "<tr><th scope='row'>". $tabue[$c] . "</th><td>" . $tabnote[$c] . "</td></tr>";
>>>>>>> a04b2ed1a6bbe3f1758bf74ddd7ad251c4d9e6aa
					}
					echo "<tbody></table>";
				}
			}
			fclose($handle);
		}
	}else{
		print('
		<h2 class="title">Formulaire de vote</h2>
		<form method="POST" action="writevote.php">
<<<<<<< HEAD
			<table class="table"><tbody>');
=======
			<table class="table">');
>>>>>>> a04b2ed1a6bbe3f1758bf74ddd7ad251c4d9e6aa
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
<<<<<<< HEAD
				</tbody><tr><td colspan="2"><center><button class="btn btn-primary" type="submit">Valider</button></center></tr></td>
=======
				<tr><td colspan="2"><center><button class="btn btn-outline-success" type="submit">Valider</button></center></tr></td>
>>>>>>> a04b2ed1a6bbe3f1758bf74ddd7ad251c4d9e6aa
			</table>
		</form>');
	}

	
}else{
    header('Location: ../index.php');  
}
?>
<<<<<<< HEAD


<?php
require_once '../panel_footer.php';
?>
=======
</body>
</html>
<br/>
<form action="../logout.php" method="post">
 <p><button type="submit" class="btn btn-outline-secondary btn-lg" name="submit" value="Déconnexion">Déconnexion</button></p>
</form>
>>>>>>> a04b2ed1a6bbe3f1758bf74ddd7ad251c4d9e6aa

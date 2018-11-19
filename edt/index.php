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
					echo "<table class='table'><tbody>";
					for ($c=0; $c < $num; $c++) {
						echo "<tr><td><strong>" . $tabue[$c] . "</strong></td><td>" . $tabnote[$note[$c]-1] . "</td></tr>";
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
			<table class="table"><tbody>');
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
				</tbody><tr><td colspan="2"><center><button class="btn btn-primary" type="submit">Valider</button></center></tr></td>
			</table>
		</form>');
	}
	if (isset($_SESSION["error"])){
		echo "<p style='color:Tomato;font-weight: bold;'>---------------- ".htmlspecialchars($_SESSION["error"])." ----------------</p>";
		unset ($_SESSION["error"]);
	}
	
}else{
    header('Location: ../index.php');  
}
?>
<?php
require_once '../panel_footer.php';
?>
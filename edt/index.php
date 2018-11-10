<style>
form{
	display: table;
}
</style>
<?php
session_start();

$tabue = array("Mathématiques","Anglais","Programmation","Algorithmique","Economie");

if ($_SESSION["role"] == "edt"){
    echo $_SESSION["id"];
	$vote = "votes/vote-".$_SESSION["id"].".csv";
	if (file_exists ($vote)){ //Si l'étudiant a voté
		$row = 1;
		if (($handle = fopen($vote, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				echo "<p> Vous avez déjà voté : <br /></p>\n";
				$row++;
				for ($c=0; $c < $num; $c++) {
					echo $tabue[$c] . " : " . $data[$c] . "<br />\n";
				}
			}
			fclose($handle);
		}
	}else{
		print('
		<h2 class="title">Formulaire de vote</h2>
		<form method="POST" action="writevote.php">
			<fieldset>');
			foreach ($tabue as $ue){
				echo $ue . " : \t" ;
				echo "<select name=" . $ue . ">";
				print('
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3" selected>Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select>
				</br>');
			}
		print('
				<button type="submit">Valider</button>
			</fieldset>
		</form>');
	}
	
}else{
    header('Location: login.php');  
}
?>


<form action="../logout.php" method="post">
 <p><input type="submit" name="submit" value="Déconnexion"></p>
</form>
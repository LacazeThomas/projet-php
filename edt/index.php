<?php
session_start();


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
					switch ($c){
						case 0:
							echo "Mathématiques : ";
							break;
						case 1:
							echo "Anglais : ";
							break;
						case 2:
							echo "Programmation : ";
							break;
						case 3:
							echo "Algorithmique : ";
							break;
						case 4:
							echo "Economie : ";
							break;
					}
					echo $data[$c] . "<br />\n";
				}
			}
			fclose($handle);
		}
	}else{
		print('
		<h2 class="title">Formulaire de vote</h2>
		<form method="POST" action="writevote.php">
			<fieldset>
				<select name="ue1">
					<option disabled="disabled" selected="selected">Mathématiques</option>
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3">Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select>
				</br>
				<select name="ue2">
					<option disabled="disabled" selected="selected">Anglais</option>
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3">Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select>
				</br>
				<select name="ue3">
					<option disabled="disabled" selected="selected">Programmation</option>
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3">Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select>
				</br>
				<select name="ue4">
					<option disabled="disabled" selected="selected">Algorithmique</option>
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3">Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select>
				</br>
				<select name="ue5">
					<option disabled="disabled" selected="selected">Economie</option>
					<option value="1">Très mécontent</option>
					<option value="2">Mécontent</option>
					<option value="3">Moyen</option>
					<option value="4">Satisfait</option>
					<option value="5">Très satisfait</option>
				</select>
				</br>
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
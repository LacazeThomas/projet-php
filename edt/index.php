<?php
require_once '../panel_header.php';



$tabue = array("Mathématiques", "Anglais", "Programmation", "Algorithmique", "Economie");
$tabnote = array("Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait");
if ($_SESSION["role"] == "edt") {
	if (isset($_SESSION["error"])) {
		echo "<div class=\"alert alert-danger\" role=\"alert\">
			" . $_SESSION["error"] . "
			</div>";
		unset($_SESSION["error"]);
	}
	
    $vote = "votes/vote-" . $_SESSION["id"] . ".csv";
    if (file_exists($vote)) { //Si l'étudiant a voté
        $row = 1;
        if (($handle = fopen($vote, "r")) !== false) {
            while (($note = fgetcsv($handle, 1000, ",")) !== false) {
                $num = count($note);
                if ($num == 5) {
					echo "<br/>";
                    echo "<h3> Merci du vote*. Voici ce que vous nous avez soumis :</h3>\n";
                    $row++;
					echo "<br/>";
                    echo "<div class=\"table-responsive-sm \"><table class=\"table-bordered table table-striped\"><thead class=\"thead-light\"><tr><tbody>";
                    for ($c = 0; $c < $num; $c++) {
                        echo "<tr><td><strong>" . $tabue[$c] . "</strong></td><td>" . $tabnote[$note[$c] - 1] . "</td></tr>";
                    }
                    echo "<tbody></table></div>";
                }
            }
            fclose($handle);
        }
    } else {
        print('
		<br/>
		<h2 class="title">Formulaire de vote*</h2>
		<form method="POST" action="writevote.php">
		<br/>
		<table class="table"><tbody>');
        foreach ($tabue as $ue) {
			echo "<div class='btn-group'>";
            echo "<tr><th scope='row'>" . $ue . "</th>";
            echo "<td><select name=" . $ue . " class='dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
            print(' <div class="dropdown-menu">
					<option class="dropdown-item" value="1">Très mécontent</option>
					<option class="dropdown-item" value="2">Mécontent</option>
					<option class="dropdown-item" value="3" selected>Moyen</option>
					<option class="dropdown-item" value="4">Satisfait</option>
					<option class="dropdown-item" value="5">Très satisfait</option>
				</select></div></td>
				</tr></div>');
        }
        print('
				</tbody><tr><td colspan="2"><center><button class="btn btn-lg" type="submit">Valider</button></center></tr></td>
			</table>
		</form>');
    }

} else {
    header('Location: /g9/index.php');
}
?>

<p><strong>(*)</strong>Les votes sont anonymes, il est donc impossible pour les professeurs et administrateurs de connaître l'identité des votants.</p>
<?php
require_once '../panel_footer.php';

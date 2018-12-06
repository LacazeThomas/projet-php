<?php
session_start();

$tabue = array("Mathématiques", "Anglais", "Programmation", "Algorithmique", "Economie"); // Tableau rassemblant le nom des UE

function verif_post($tabue){ // Fonction de vérification de la validité du vote entré
    for ($i = 0; $i < 5; ++$i) { // Pour chaque notation d'UE
        if (isset($_POST[$tabue[$i]])) { // Si la note existe..
            $_POST[$tabue[$i]] = intval($_POST[$tabue[$i]]); // Transformation en int (Entrée sûre car renvoie 0 si échec)
            if ($_POST[$tabue[$i]] < 1 or $_POST[$tabue[$i]] > 5) { // Si la note est comprise hors de Très mécontent(1) et Très satisfait (5)
				$_SESSION["error"] = "Les valeurs entrées sont incorrectes"; // On définit une erreur
				return False;
            }
        } else { // Si la note n'est pas renseignée..
			$_SESSION["error"] = "Pas de valeurs entrées"; // On définit une erreur
			return False;
        }
	}
	return True; // Si tout se passe comme prévu, on valide le vote
}

if (isset($_SESSION['id'])) { // Si l'utilisateur est authentifié..
    if ($_SESSION['role'] == "edt") { // ..qu'il s'agit d'un étudiant..
        
        if (verif_post($tabue)) { // ..et que son vote est valide..
            $tabvotes = array();

            foreach ($tabue as $ue) {
                if (isset($_POST[$ue])) {
                    array_push($tabvotes, $_POST[$ue]);
                }
            }

            $fp = fopen("votes/vote-" . $_SESSION["id"] . ".csv", "w"); // On ouvre le fichier correspondant à l'étudiant en écriture

            fputcsv($fp, $tabvotes, ","); // On écrit dans ce fichier les votes séparés par deds virgules

            fclose($fp); // On ferme le pointeur
        } else { // Si son vote est invalide, il est redirigé vers l'index où l'erreur s'affichera
            header("Location: index.php");
        }
    }
}
header('Location: index.php');
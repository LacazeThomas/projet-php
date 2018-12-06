<?php
require_once '../panel_header.php'; //On ajoute le header avec la session_start()

if ($_SESSION["role"] == "prof") {

    $votes = array();
    if ($handle = opendir('../edt/votes')) { //On lit les votes et on les push tous dans le tableau $votes
        //On fait attention aux fichiers présents avec un preg_match

        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && preg_match('/^vote-e([0-9]{4})\.(csv)$/i', $entry)) {
                array_push($votes, $entry);
            }
        }
        if (empty($votes)) {
            die("Aucun vote n'a été enregistré"); //Si il n'y a aucun vote on génére une erreur et on arrete l'affichage de la page
        }

        closedir($handle);
    }
    $avis = array();
    foreach ($votes as $file_vote) { //On lit les fichiers un par un et on ajout les votes dans un tableau $avis
        $lines = file('../edt/votes/' . $file_vote);
        foreach ($lines as $line) {
            $avis[] = str_getcsv($line);
        }
    }
    echo "<br/>";
    echo "<h2>Voici les avis des étudiants pour votre matière (";

    $prof_ue = (int) filter_var($_SESSION["id"], FILTER_SANITIZE_NUMBER_INT); //On récupere l'UE ou le prof enseigne
    switch ($prof_ue) {
        case 1:
            echo "Mathématiques) ";
            break;
        case 2:
            echo "Anglais) ";
            break;
        case 3:
            echo "Programmation) ";
            break;
        case 4:
            echo "Algorithmique) ";
            break;
        case 5:
            echo "Economie) ";
            break;
    }
    echo "</h2>";
    echo "<br/>";

    $notation = array("", "Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait");
    $temp = $notation;
    array_shift($temp); //Pour les graphiques
    $_SESSION["graph_matiere"] = $temp; //Pour les graphiques
    $graph_count = array();
    echo "<div class=\"table-responsive-sm\"><table class=\"table-bordered table table-striped\"><thead><tr>";

    foreach ($notation as $avi) {
        echo "<th>" . $avi . "</th>";
    } //On affiche les avis qui sont disponible ("Très mécontent")...

    echo "<th>Total</th>";

    echo "</tr></thead>";
    echo "<tbody>";
    $nombre_votant = count($votes);
    echo "<tr><th scope=\"row\">Répartion</th>";
    for ($i = 0; $i < 5; $i++) { //on calcul pour chaque avi possible leur nombre d'itération
        $count = 0;
        for ($y = 0; $y < $nombre_votant; $y++) {
            if ($avis[$y][$prof_ue - 1] == $i + 1) {
                $count++;
            }
        }
        echo "<td>" . $count . "</td>";
        array_push($graph_count, $count);
    }
    echo "<td>" . $nombre_votant . "</td>";
    $_SESSION["graph_count"] = $graph_count; //Pour les graphiques
    echo "</tbody></table></div>";

} else {
    header('Location: /g9');
}
echo "<br/>";
?>


<div class="d-flex"> <!-- On ajoute le graph qui utilise les session générées -->
    <?php include '../assets/graph/basic.php';?>
</div>


<?php
require_once '../panel_footer.php';
?>
<?php
require_once '../panel_header.php'; 
?>
<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                    aria-controls="collapseOne">
                    Tableau répartition des notes
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <?php

function ecart_type($arr)
{
    $num_of_elements = count($arr);
    $variance = 0.0;
    $average = array_sum($arr) / $num_of_elements;

    foreach ($arr as $i) {

        $variance += pow(($i - $average), 2);
    }

    return (float) sqrt($variance / $num_of_elements);
}

if ($_SESSION["role"] == "admin") {

    $pdf_rep = array();
    $pdf_stat = array();
    $notation = array("", "Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait","Total");
    $matière = array("Maths", "Anglais", "Programmation", "Algorithmique", "Economie");
    $votes = array();
    $avis = array();
    $moyenne = array();
    $ecart = array();
    if ($handle = opendir('../edt/votes')) {  //On lit les votes et on les push tous dans le tableau $votes
        //On fait attention aux fichiers présents avec un preg_match
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && preg_match('/^vote-e([0-9]{4})\.(csv)$/i', $entry)) {
                array_push($votes, $entry);
            }
        }
        if (empty($votes)) {
            die("Aucun vote n'a été enregistré");//Si il n'y a aucun vote on génére une erreur et on arrete l'affichage de la page
        }

        closedir($handle);
    }

    foreach ($votes as $file_vote) {//On lit les fichiers un par un et on ajout les votes dans un tableau $avis
        $lines = file('../edt/votes/' . $file_vote);
        foreach ($lines as $line) {
            $avis[] = str_getcsv($line);
        }

    }
    echo "<h2>Répartition (nombre d'étudiants) </h2>";
    echo "<div class=\"table-responsive-sm \"><table class=\"table-bordered table table-striped\"><thead class=\"thead-light\"><tr>";
    foreach ($notation as $avi) {
        echo "<th>" . $avi . "</th>";
    }

    echo "</tr></thead>";


    $maths = array();
    $anglais = array();
    $prog = array();
    $algo = array();
    $eco = array();
    array_push($pdf_rep, $notation);
    echo "<tbody>";
    foreach ($avis as $edt) { //On ajoute chaque avis dans la matiere qui correspond. Pour faciliter les opérations par la suite 
        $col = 0;
        foreach ($edt as $avi) {
            $col = $col + 1;
            if ($col == 1) {
                array_push($maths, $avi);
            } elseif ($col == 2) {
                array_push($anglais, $avi);
            } elseif ($col == 3) {
                array_push($prog, $avi);
            } elseif ($col == 4) {
                array_push($algo, $avi);
            } else {
                array_push($eco, $avi);
                $col = 0; //Par sécurité
            }
        }
    }
    $matieres_notes = array($maths, $anglais, $prog, $algo, $eco); //On crée un array 2d avec les avis des matieres pour facilier le parcours
    $compteur_matiere = 0;
    foreach ($matieres_notes as $ue) {
        $pdf_parse = array();
        echo "<tr><th scope=\"row\">" . $matière[$compteur_matiere] . "</th>";
        array_push($pdf_parse, $matière[$compteur_matiere]);
        $compteur_matiere++;
        for ($i = 0; $i <= count($notation) - 3; $i++) {
            $count = 0;
            foreach ($ue as $item) {
                if ($item == $i + 1) {
                    $count++; //On compte le nombre de répétition du meme avis dans la meme matiere
                }

            }
            array_push($pdf_parse, $count); //On l'ajoute pour le pdf 
            echo "<td>" . $count . "</td>"; //Et on l'affiche sur la page
        }
        echo "<td>" . array_sum($pdf_parse) . "</td>"; //On affiche le total de votant pour la matière


        array_push($pdf_parse, array_sum($pdf_parse));
        array_push($pdf_rep, $pdf_parse); //On ajoute le parse dans le pdf pour former un tab 2D comme l'affichage en html
    }

    echo "</tbody></table></div>";


    echo "<h2>Statistiques</h2>";
    echo "<div class=\"row\">
    <div class=\"col-8\">";
    echo "<div class=\"table-responsive-sm \"><table class=\"table-bordered table table-striped\"><thead class=\"thead-light\"><tr>";
    echo "<th></th>";
    echo "<th>Moyenne</th>";
    echo "<th>Ecart-Type</th>";
    echo "</tr></thead>";

    echo "<tbody>";

    $compteur_matiere = 0;
    //On reproduit la meme chose que pour la répartiton avec pour la moyenne et l'écartype 
    $pdf_parse = array("","Moyenne","Ecart-Type");
    array_push($pdf_stat, $pdf_parse);

    foreach ($matieres_notes as $ue) {
        $pdf_parse = array();
        echo "<tr><th scope=\"row\">" . $matière[$compteur_matiere] . "</th>";
        array_push($pdf_parse, $matière[$compteur_matiere]);
        $compteur_matiere++;

        $moy = round(array_sum($ue) / count($ue), 2);
        echo "<td>" . $moy . "</td>";
        array_push($moyenne, $moy);
        array_push($pdf_parse, $moy);

        $ect = round(ecart_type($ue), 2);
        echo "<td>" . $ect . "</td></tr>";
        array_push($ecart, $ect);
        array_push($pdf_parse, $ect);

        array_push($pdf_stat, $pdf_parse);
    }

    echo "</tbody></table></div></div>";


    if (isset($_REQUEST['submitPDF'])) { //Si l'administrateur souhaite un pdf
        $_SESSION["table_rep"] = $pdf_rep; //Array de la répartion des notes
        $_SESSION["table_stat"] = $pdf_stat; //Array des statistiques (moyenne, ecartype)
        header('Location: pdf/');
    }

} else {
    header('Location: /g9/');
}
?>
                <div class="col-4">
                    <div class="table-responsive-sm">
                        <table class="table-bordered table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="2">Barème</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <td> Très mécontent</td>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <td> Mécontent</td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td> Moyen</td>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <td> Satisfait</td>
                                </tr>
                                <tr>
                                    <th>5</th>
                                    <td>Très satisfait</td>
                                </tr>
                                <tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <p><button type="submit" class="btn btn-primary" name="submitPDF" value="PDF">Générer le PDF</button></p>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                aria-controls="collapseTwo">
                Graphique de l'ensemble des avis tout UE confondu
            </button>
        </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
            <?php
$graph_count = array(); //Array pour stocker la totalité des avis tout UE confondu
for ($i = 0; $i < 5; $i++) {
    $count = 0;
    for ($y = 0; $y < count($votes); $y++) {
        for ($p = 0; $p < count($matière); $p++) {
            if ($avis[$y][$p] == $i + 1) {
                $count++;
            }

        }
    }
    array_push($graph_count, $count); 
}
$_SESSION["graph_count"] = $graph_count;
$_SESSION["graph_matiere"] = array("Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait");

$_SESSION["graph_matiere_line"] = $matière;
$_SESSION["graph_count_line"] = $moyenne;
$_SESSION["graph_ec_line"] = $ecart;
?>
            <?php include '../assets/graph/basic.php';?>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header" id="headingThree">
        <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                aria-controls="collapseThree">
                Informations complémentaires
            </button>
        </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <?php include '../assets/graph/line.php';?>
                </div>
                <div class="col-sm">
                    <?php include '../assets/graph/line_ec.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php
require_once '../panel_footer.php';
?>
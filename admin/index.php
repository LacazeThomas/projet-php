<?php
require_once '../panel_header.php';
require 'pdf/mc_table.php';
?>
<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Tableau répartition des notes
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
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

    $pdf = array();
    $notation = array("", "Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait", "Moyenne", "Ecart-type");
    $matière = array("Maths", "Anglais", "Programmation", "Algorithmique", "Economie");
    $maths = array();
    $anglais = array();
    $prog = array();
    $algo = array();
    $eco = array();
    $votes = array();
    $avis = array();
    $moyenne = array();
    $ecart = array();
    if ($handle = opendir('../edt/votes')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && preg_match('/^.*\.(csv)$/i', $entry)) {
                array_push($votes, $entry);
            }
        }
        if (empty($votes)) {
            die("Aucun vote n'a été enregistré");
        }

        closedir($handle);
    }

    foreach ($votes as $file_vote) {
        $lines = file('../edt/votes/' . $file_vote);
        foreach ($lines as $line) {
            $avis[] = str_getcsv($line);
        }

    }

    echo "<div class=\"table-responsive-sm \"><table class=\"table-bordered table table-striped\"><thead class=\"thead-light\"><tr>";
    foreach ($notation as $avi) {
        echo "<th>" . $avi . "</th>";
    }

    echo "</tr></thead>";

    array_push($pdf, $notation);
    echo "<tbody>";
    foreach ($avis as $edt) {
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
    $matieres_notes = array($maths, $anglais, $prog, $algo, $eco);
    $compteur_matiere = 0;
    foreach ($matieres_notes as $ue) {
        $pdf_parse = array();
        echo "<tr><th scope=\"row\">" . $matière[$compteur_matiere] . "</th>";
        array_push($pdf_parse, $matière[$compteur_matiere]);
        $compteur_matiere++;
        for ($i = 0; $i <= count($notation) - 4; $i++) {
            $count = 0;
            foreach ($ue as $item) {
                if ($item == $i + 1) {
                    $count++;
                }

            }
            array_push($pdf_parse, $count);
            echo "<td>" . $count . "</td>";
        }
        echo "<td>" . round(array_sum($ue) / count($ue), 2) . "</td>";
        array_push($pdf_parse, round(array_sum($ue) / count($ue), 2));
        array_push($moyenne, round(array_sum($ue) / count($ue), 2));
        echo "<td>" . round(ecart_type($ue), 2) . "</td>";
        array_push($ecart, round(ecart_type($ue), 2));
        array_push($pdf_parse, round(ecart_type($ue), 2));
        echo "</tr>";
        array_push($pdf, $pdf_parse);
    }

    echo "</tbody></table></div>";

    if (count($votes) > 1) {
        echo "<h3>Il y a " . count($votes) . " étudiants qui ont voté </h3>";
    } else {
        echo "<h3>Il y a 1 étudiant qui a voté </h3>";
    }

    if (isset($_REQUEST['submitPDF'])) {
        $_SESSION["table"] = $pdf;
        header('Location: pdf/index.php');
    }

} else {
    header('Location: ../index.php');
}

?>
<form action="" method="post">
 <p><button type="submit" class="btn btn-primary" name="submitPDF" value="PDF">Générer le PDF</button></p>
</form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Graphique de l'ensemble des avis tout UE confondu
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
      <?php
$graph_count = array();
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
$_SESSION["graph_ec_line"] = $ecart
?>
        <?php include '../assets/graph/basic.php';?>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
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
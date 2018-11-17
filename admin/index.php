<?php
require_once '../panel_header.php';
require 'pdf/mc_table.php';
?>
<h1>Voici les avis des étudiants pour toutes matières:</h1>
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

    echo "<div class=\"table-responsive-sm\"><table class=\"table\"><thead><tr>";

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
        echo "<td>" . round(ecart_type($ue), 2) . "</td>";
        array_push($pdf_parse, round(ecart_type($ue), 2));
        echo "</tr>";
        array_push($pdf, $pdf_parse);
    }

    echo "</tbody></table></div>";

    if (isset($_REQUEST['submitPDF'])) {
        $_SESSION["table"] = $pdf;
        header('Location: pdf/index.php');
    }

} else {
    header('Location: ../index.php');
}

?>
<p>Le barême est le suivant :</p>
<li>1 : Très mécontent</li>
<li>2 : Mécontent</li>
<li>3 : Moyen</li>
<li>4 : Satisfait</li>
<li>5 : Très satisfait</li>

<form action="" method="post">
 <p><button type="submit" class="btn btn-primary" name="submitPDF" value="PDF">Générer le PDF</button></p>
</form>

<?php
require_once '../panel_footer.php';
?>
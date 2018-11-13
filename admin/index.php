<?php
session_start();
require 'pdf/mc_table.php';
require('../header.php')

?>
<link rel="stylesheet" href="../assets/css/style.css" />
<?php

function ecart_type($arr)
{
    $num_of_elements = count($arr);

    $variance = 0.0;

    // calculating mean using array_sum() method
    $average = array_sum($arr) / $num_of_elements;

    foreach ($arr as $i) {
        // sum of squares of differences between
        // all numbers and means.
        $variance += pow(($i - $average), 2);
    }

    return (float) sqrt($variance / $num_of_elements);
}

if ($_SESSION["role"] == "admin") {
    echo "Bonjour ", $_SESSION["id"], "</br>";

    $votes = array();
    if ($handle = opendir('../edt/votes')) {

        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                array_push($votes, $entry);
            }
        }

        closedir($handle);
    }
    $avis = array();
    foreach ($votes as $file_vote) {
        $lines = file('../edt/votes/' . $file_vote);
        foreach ($lines as $line) {
            $avis[] = str_getcsv($line);
        }
    }
    $pdf = array();
    echo "Voici les avis des etudiants pour toutes matières:</br>";

    echo "<table>
    <tr>
        <th></th>
        <th>Mathématiques</th>
        <th>Anglais</th>
        <th>Programmation</th>
        <th>Algorithmique</th>
        <th>Economie</th>
    </tr>
    ";
    array_push($pdf, array("", "Maths", "Anglais", "Programmation", "Algorithmique", "Economie"));
    $maths = array();
    $anglais = array();
    $prog = array();
    $algo = array();
    $eco = array();
    foreach ($avis as $edt) {
        $pdf_parse = array();
        echo "<tr><td>Anonyme</td>";
        array_push($pdf_parse, "Anonyme");
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
            echo "<td>";
            switch ($avi) {
                case 1:
                    echo "Très mécontent";
                    array_push($pdf_parse, "Tres mecontent");
                    break;
                case 2:
                    echo "Mécontent";
                    array_push($pdf_parse, "Mecontent");
                    break;
                case 3:
                    echo "Moyen";
                    array_push($pdf_parse, "Moyen");
                    break;
                case 4:
                    echo "Satisfait";
                    array_push($pdf_parse, "Satisfait");
                    break;
                case 5:
                    echo "Très satisfait";
                    array_push($pdf_parse, "Tres satisfait");
                    break;
            }

            echo "</td>";
        }
        array_push($pdf, $pdf_parse);
        echo "</tr>";
    }
    $pdf_parse = array();
    $matieres_notes = array($maths, $anglais, $prog, $algo, $eco);
    echo "
    <tr>
    <td>Moyenne</td>";
    array_push($pdf_parse, "Moyenne");
    foreach ($matieres_notes as $matiere) {
        echo "<td>" . round(array_sum($matiere) / count($matiere),3) . "</td>";
        array_push($pdf_parse, array_sum($matiere) / count($matiere));
    }
    echo "</tr>";
    array_push($pdf, $pdf_parse);
    $pdf_parse = array();
    array_push($pdf_parse, "Ecartype");
    echo "
    <tr>
    <td>Ecartype</td>";

    foreach ($matieres_notes as $matiere) {
        echo "<td>" . round(ecart_type($matiere),3) . "</td>";
        array_push($pdf_parse, ecart_type($matiere));
    }
    array_push($pdf, $pdf_parse);
    echo "</tr>
    </table>";

    if (isset($_REQUEST['submitPDF'])) {
        $_SESSION["table"] = $pdf;
        header('Location: pdf/index.php');
    }

} else {
    header('Location: login.php');
}
?>
<p>Le barême est le suivant :</p>
<ul>
<li>1 : Très mécontent</li>
<li>2 : Mécontent</li>
<li>3 : Moyen</li>
<li>4 : Satisfait</li>
<li>5 : Très satisfait</li>
</ul>

<form action="../logout.php" method="post">
 <p><button type="submit" name="submit" value="Déconnexion">Déconnexion</button></p>
</form>


<form action="" method="post">
 <p><button type="submit" name="submitPDF" value="PDF">PDF</button></p>
</form>
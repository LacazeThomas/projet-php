<?php
session_start();?>
<link rel="stylesheet" href="../assets/css/main.css" />
<?php

function ecart_type($arr) 
    { 
        $num_of_elements = count($arr); 
          
        $variance = 0.0; 
          
                // calculating mean using array_sum() method 
        $average = array_sum($arr)/$num_of_elements; 
          
        foreach($arr as $i) 
        { 
            // sum of squares of differences between  
                        // all numbers and means. 
            $variance += pow(($i - $average), 2); 
        } 
          
        return (float)sqrt($variance/$num_of_elements); 
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

    $maths = array();
    $anglais = array();
    $prog = array();
    $algo = array();
    $eco = array();
    foreach ($avis as $edt) {
        echo "<tr><td>Anonyme</td>";
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
                    break;
                case 2:
                    echo "Mécontent";
                    break;
                case 3:
                    echo "Moyen";
                    break;
                case 4:
                    echo "Satisfait";
                    break;
                case 5:
                    echo "Très satisfait";
                    break;
            }

            echo "</td>";
        }
        echo "</tr>";
    }
    $matieres_notes = array($maths, $anglais, $prog, $algo, $eco);
    echo "
    <tr>
    <td>Moyenne</td>";

    foreach ($matieres_notes as $matiere) {
        echo "<td>". array_sum($matiere) / count($matiere)."</td>";
    }
    echo "</tr>";
    echo "
    <tr>
    <td>Ecartype</td>";

    foreach ($matieres_notes as $matiere) {
        echo "<td>".ecart_type($matiere)."</td>";
    }
    echo "</tr>
    </table>";
} else {
    header('Location: login.php');
}
?>


<form action="../logout.php" method="post">
 <p><input type="submit" name="submit" value="Déconnexion"></p>
</form>

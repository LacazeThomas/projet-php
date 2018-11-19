<?php
require_once '../panel_header.php';

if ($_SESSION["role"] == "prof") {

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
    echo "<h2>Voici les avis des etudiants pour la matière ";
    $prof_ue = (int) filter_var($_SESSION["id"], FILTER_SANITIZE_NUMBER_INT);
    switch ($prof_ue) {
        case 1:
            echo "Mathématiques ";
            break;
        case 2:
            echo "Anglais ";
            break;
        case 3:
            echo "Programmation ";
            break;
        case 4:
            echo "Algorithmique ";
            break;
        case 5:
            echo "Economie ";
            break;
    }
    echo "sont: </h2>";

    $notation = array("", "Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait");
    echo "<div class=\"table-responsive-sm\"><table class=\"table\"><thead><tr>";

    foreach ($notation as $avi) {
        echo "<th>" . $avi . "</th>";
    }

    echo "</tr></thead>";
    echo "<tbody>";
    $nombre_votant = count($votes)-1;
    echo "<tr><th scope=\"row\">Répartion</th>";
        for ($i = 0; $i < 5; $i++) {
            $count = 0;
            for ($y = 0; $y < $nombre_votant ; $y++) {
                if ($avis[$y][$prof_ue - 1] == $i + 1) {
                    $count++;
                }
            }
        echo "<td>" . $count . "</td>";
    }
    echo "</tbody></table></div>";
    if($nombre_votant > 1){
        echo "<h3>Il y a ".$nombre_votant." étudiants qui ont voté </h3>";
    }else{
        echo "<h3>Il y a 1 étudiant qui a voté </h3>";
    }
} else {
    header('Location: ../');
}
?>


<?php
require_once '../panel_footer.php';
?>
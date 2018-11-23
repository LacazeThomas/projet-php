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
    echo "<h2>Voici les avis des étudiants pour votre matière (";
    $prof_ue = (int) filter_var($_SESSION["id"], FILTER_SANITIZE_NUMBER_INT);
    switch ($prof_ue) {
        case 1:
            echo "Mathématiques) ";
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
    echo "</h2>";

    $notation = array("", "Très mécontent", "Mécontent", "Moyen", "Satisfait", "Très satisfait");
    $temp = $notation;
    array_shift($temp);
    $_SESSION["graph_matiere"] = $temp;
    $graph_count = array();
    echo "<div class=\"table-responsive-sm\"><table class=\"table-bordered table table-striped\"><thead><tr>";

    foreach ($notation as $avi) {
        echo "<th>" . $avi . "</th>";
    }
    echo"<th>Total</th>";

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
        array_push($graph_count, $count);
        }
    echo "<td>".$nombre_votant."</td>";
    $_SESSION["graph_count"] = $graph_count;
    echo "</tbody></table></div>";

    
} else {
    header('Location: ../');
}
?>


<div class="d-flex">
  <?php include('graph/index.php'); ?>
</div>


<?php
require_once '../panel_footer.php';
?>
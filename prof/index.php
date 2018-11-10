<?php
session_start();
if ($_SESSION["role"] == "prof") {
    echo "Bonjour ",$_SESSION["id"],"</br>";

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
    echo "Voici les avis des etudiants pour la matière ";
    $prof_ue = (int) filter_var($_SESSION["id"], FILTER_SANITIZE_NUMBER_INT);
    switch ($prof_ue){
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
    echo "sont: </br>";
    
    foreach ($avis as $avi) {
        switch ($avi[$prof_ue-1]){
            case 1:
                echo "Très mécontent </br>";
                break;
            case 2:
                echo "Mécontent </br>";
                break;
            case 3:
                echo "Moyen </br>";
                break;
            case 4:
                echo "Satisfait </br>";
                break;
            case 5:
                echo "Très satisfait </br>";
                break;
        }
    }

} else {
    header('Location: login.php');
}
?>


<form action="../logout.php" method="post">
 <p><input type="submit" name="submit" value="Déconnexion"></p>
</form>

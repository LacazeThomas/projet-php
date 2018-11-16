<?php
require('header.php')
?>
<br/>
<h3>Connexion</h3>
<br/>
<?php
session_start();

$idP = array();
$idE = array();
$idA = array();
$linesP = file('prof/id-profs.csv');
$linesE = file('edt/id-student.csv');
$linesA = file('admin/id-admin.csv');

foreach ($linesP as $key => $value)
{
    $idP[$key] = str_getcsv($value);
}
foreach ($linesE as $key => $value)
{
    $idE[$key] = str_getcsv($value);
}
foreach ($linesA as $key => $value)
{
    $idA[$key] = str_getcsv($value);
}

if(isset($_REQUEST['submit'])){
    if($_POST['id'] && $_POST['mdp']){
        foreach($idP as $val){
            if($_POST['id'] == $val[0] and $_POST['mdp'] == $val[1]){
                $_SESSION["id"] = $_POST["id"];
                $_SESSION["role"] = "prof";
                header('Location: prof/index.php');  
            }else{
                $_SESSION["error"] = "Oups, votre identifiant ou mot de passe est incorrect";
            }
        }
		foreach($idE as $val){
            if($_POST['id'] == $val[0] and $_POST['mdp'] == $val[1]){
                $_SESSION["id"] = $_POST["id"];
                $_SESSION["role"] = "edt";
                header('Location: edt/index.php');  
            }else{
                $_SESSION["error"] = "Oups, votre identifiant ou mot de passe est incorrect";
            }
        }
		foreach($idA as $val){
            if($_POST['id'] == $val[0] and $_POST['mdp'] == $val[1]){
                $_SESSION["id"] = $_POST["id"];
                $_SESSION["role"] = "admin";
                header('Location: admin/index.php');  
            }else{
                $_SESSION["error"] = "Oups, votre identifiant ou mot de passe est incorrect";
            }
        }
    }
}
?>

<?php
    if(isset($_SESSION["error"])){
        echo $_SESSION["error"];
        unset($_SESSION["error"]);
    }
?>
<form action="" method="POST">
<input type="text" placeholder="Identifiant" name="id" required>
<input type="password" placeholder="Mot de passe" name="mdp" required>
<button type="submit" name='submit'>Connexion</button>
</form>
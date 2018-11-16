<?php
require('../header.php')
?>

<?php
session_start();

$id = array();
$lines = file('id-admin.csv');

foreach ($lines as $key => $value)
{
    $id[$key] = str_getcsv($value);
}


if(isset($_REQUEST['submit'])){
    
    if($_POST['id'] && $_POST['mdp']){
        foreach($id as $val){
            if($_POST['id'] == $val[0] and $_POST['mdp'] == $val[1]){
                $_SESSION["id"] = $_POST["id"];
                $_SESSION["role"] = "admin";
                header('Location: index.php');  
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
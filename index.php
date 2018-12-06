<?php
require_once 'panel_header.php';

if (isset($_SESSION["role"])) { //Redirection en fonction du rôle si la session est trouvée
    header('Location: /g9/'.$_SESSION["role"]);
}

function verif($file, $role){ 
    /* Fonction de vérification de l'utilisateur
    file -> correspond au ficher ou se trouve les identifiants et mot de passe
    role -> correspond au grade de l'utilisateur */

    $id = array(); 
    $lines = file("file/".$file);
    foreach ($lines as $key => $value)
    {
        $id[$key] = str_getcsv($value);
    } // On stocke les identifiants et mot de passe dans un tableau 2D
    //
    
    if(isset($_REQUEST['submit'])){ 
        if($_POST['id'] && $_POST['mdp']){ //Si les deux champs sont renseigner
            foreach($id as $val){ //Pour chaque identifiant
                if($_POST['id'] == $val[0] and $_POST['mdp'] == $val[1]){ //On test si le login et password est trouvé
                    $_SESSION["id"] = $_POST["id"]; //On peut lui donner un id
                    $_SESSION["role"] = $role; //Et un rôle
                    header('Location: '.$role.'/');  //Puis on le redirige dans le dossier de son role
                }else{
                    $_SESSION["error"] = "Oups, votre identifiant ou mot de passe est incorrect."; //Si le mot de passe est faux
                }
            }
        }
    }
}
//Ficher de connecter et le rôle de chaqu'un
verif("id-profs.csv", "prof");
verif("id-admin.csv", "admin");
verif("id-student.csv", "edt");

?>

<h2>Bienvenue sur la plateforme de vote de l'IUT</h2>
<img src="/g9/assets/img/bandeau.png" class="rounded img-fluid" alt="" />
<br />
<h5>Veuillez entrer vos informations</h5>

<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>" method="post">
    <?php
    if(isset($_SESSION["error"])){
        echo "<div class=\"alert alert-danger\" role=\"alert\">
        ".$_SESSION["error"]."
        </div>";
        unset ($_SESSION["error"]);
    }
?>
    <input name="id" type="text" class="form-control" placeholder="Identifiant" required autofocus>
    <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Connexion</button>
</form>


<?php
require_once 'panel_footer.php';
?>
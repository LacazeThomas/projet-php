<?php
require_once 'panel_header.php';

if (isset($_SESSION["role"])) {
    header('Location: /g9/'.$_SESSION["role"]);
}

function verif($file, $role){
    $id = array();
    $lines = file("file/".$file);
    foreach ($lines as $key => $value)
    {
        $id[$key] = str_getcsv($value);
    }
    
    if(isset($_REQUEST['submit'])){
        if($_POST['id'] && $_POST['mdp']){
            foreach($id as $val){
                if($_POST['id'] == $val[0] and $_POST['mdp'] == $val[1]){
                    $_SESSION["id"] = $_POST["id"];
                    $_SESSION["role"] = $role;
                    header('Location: '.$role.'/index.php');  
                }else{
                    $_SESSION["error"] = "Oups, votre identifiant ou mot de passe est incorrect.";
                }
            }
        }
    }
}

verif("id-profs.csv", "prof");
verif("id-admin.csv", "admin");
verif("id-student.csv", "edt");

?>

<h2>Bienvenue sur la plateforme de vote de l'IUT</h2>
<img src="/g9/assets/img/bandeau.png" class="rounded img-fluid" alt= ""/>
<br/>
<h5>Veuillez entrer vos informations</h5>

<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<?php
    if(isset($_SESSION["error"])){
        echo "<div class=\"alert alert-danger\" role=\"alert\">
        ".$_SESSION["error"]."
        </div>";
        unset ($_SESSION["error"]);
    }
?>
            <input name="id" type="text" class="form-control" placeholder="Identifiant" required autofocus>
            <input type="password" name="mdp"  class="form-control" placeholder="Mot de passe" required>
            <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Connexion</button>
        </form>


<?php
require_once 'panel_footer.php';
?>

<?php
session_start();


if ($_SESSION["role"] == "admin"){
    echo $_SESSION["id"];
}else{
    header('Location: login.php');  
}
?>


<form action="../logout.php" method="post">
 <p><input type="submit" name="submit" value="Déconnexion"></p>
</form>
<?php
    session_start();
    require "conf.inc.php";
    require "core/functions.php";
?>
<?php include "template/header.php";?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="" href="NewPassword.css">
    <style>
        
        body {
    font-family: Centaur;
    background-color: beige;
    padding: 30px;
}

h1 {

    font-family: Bernard MT;

}

    </style>
</head>

<div class="">
    
    <?php

//if( !empty($_POST['email']) &&  !empty($_POST['pwd']) ){

    if( !empty($_POST['old_pwd']) && !empty($_POST['new_pwd']) && !empty($_POST['confirm_new_pwd'])){

// Récupère l'adresse email de l'utilisateur de la session

        $email = $_SESSION['email'];  
// Récupère "ancien mot de passe" 

        $old_pwd = $_POST["old_pwd"];
// Récupère "nouveau mot de passe"
        $new_pwd = $_POST["new_pwd"];

        $confirm_new_pwd = $_POST["confirm_new_pwd"];

// POPUP suite à la modification du mot de passe échoué

        if($new_pwd !== $confirm_new_pwd){
            echo "<script type='text/javascript'>alert('La confirmation du nouveau mot de passe ne correspond pas');</script>";
            exit();
        }

// Connexion à la DB avec "connectDB" définie dans "functions.php"

        $connect = connectDB();

//Récupérer le mot de passe actuel de l'utilisateur

        $queryPrepared = $connect->prepare("SELECT pwd FROM ".DB_PREFIX."user WHERE email=:email");

// Exécute l'adresse email de l'utilisateur à la variable ":email"

        $queryPrepared->execute(["email"=>$email]);

// Récupère les résultats sous forme de tableau
            
        $results = $queryPrepared->fetch(); 


        if(!empty($results) && password_verify($old_pwd, $results["pwd"]) ){

// Hasher le nouveau mot de passe

            $hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);

// Mettre à jour le mot de passe dans la base de données
// POPUP suite à la modification du mot de passe réussi

            $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."user SET pwd=:pwd WHERE email=:email");
            $queryPrepared->execute(["email"=>$email, "pwd"=>$hashed_pwd]);
            echo "<script type='text/javascript'>alert('Mot de passe modifié avec succès');</script>";
        }else{
            echo "<script type='text/javascript'>alert('Ancien mot de passe incorrect');</script>";
        }
    }
?>

    <div class="row">
        <div class="col-12">
            <form method="POST">
                <center><h1>Modifier mot de passe</h1>
                <br>
                <br>
                <br>

                <input type="password" name="old_pwd" placeholder="Ancien mot de passe" required="required">
                <br>
                <br>
                <input type="password" name="new_pwd" placeholder="Nouveau mot de passe" required="required">
                
                <input type="password" name="confirm_new_pwd" placeholder="Confirmation" required="required">
                <br>
                <br>

                <button>Modifier</button>

            </form>
        </div>
    </div>
</div>

<?php include "template/footer.php";?>

<!--LOGS-->

<?php

//Récupérer la date
$month = "[".date("d")."/".date("m")."/".date("y")."] ";

//Récupérer l'heure
$hour = "[".date("H").":".date("i").":".date("s")."] ";

//Récupérer l
// $_SERVER['SERVER_NAME'] permet de récuper le nom du site
//$_SERVER['REMOTE_ADDR'] récupére l'adresse de la personne connecté
$url = $_SERVER['REMOTE_ADDR']." connect to ".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
// On réuni le tout 
$logs = $month.$hour.$url."\n";

$files = fopen("logs.txt", "a+");
fputs($files ,$logs);
fclose($files);

?>
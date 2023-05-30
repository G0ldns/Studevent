<?php
session_start();
require "conf.inc.php";
require "core/functions.php";
include "template/header.php";

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil de <?= htmlspecialchars($user['pseudo']) ?></title>
    <link rel="stylesheet" type="" href="profil.css">
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
<body>

    <?php 

if(!isset($_SESSION['email']) || !isset($_SESSION['login'])){
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Connexion à la base de données
$connect = connectDB();

// Si l'utilisateur soumet le formulaire de modification
if(isset($_POST['submit'])){
    // Récupérer les nouvelles informations de l'utilisateur
    $pseudo = $_POST['pseudo'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $bio = $_POST['bio'];
    // Requête pour mettre à jour les informations de l'utilisateur
    $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."user SET pseudo=:pseudo, firstname=:firstname, lastname=:lastname, gender=:gender, country=:country, bio=:bio WHERE email=:email");
    $queryPrepared->execute(["pseudo" => $pseudo, "firstname" => $firstname, "lastname" => $lastname, "gender" => $gender, "country" => $country, "email" => $email, "bio" => $bio]);

    // Requête pour récupérer les informations de l'utilisateur mises à jour
    $queryPrepared = $connect->prepare("SELECT pseudo, firstname, lastname, gender, country, bio FROM ".DB_PREFIX."user WHERE email=:email");
    $queryPrepared->execute(["email" => $email]);
    $user = $queryPrepared->fetch();
} else {
    // Requête pour récupérer les informations de l'utilisateur
    $queryPrepared = $connect->prepare("SELECT pseudo, firstname, lastname, gender, country, bio FROM ".DB_PREFIX."user WHERE email=:email");
    $queryPrepared->execute(["email" => $email]);
    $user = $queryPrepared->fetch();
}

?>



    <center><h1>Votre Profil</h1></center>
    <form method="post" action="profil.php">
        <div class="user-info">
            
            <p><label>Pseudo :</label> <input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>"></p>
            <p><label>Prénom :</label> <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>"></p>
            <p><label>Nom :</label> <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>"></p>
            <p><label>Genre :</label> 
                <select name="gender" id="gender-select">
    <option value="0" <?= $user['gender'] === '0' ? 'selected' : '' ?>>Homme</option>
    <option value="1" <?= $user['gender'] === '1' ? 'selected' : '' ?>>Femme</option>
    <option value="2" <?= $user['gender'] === '2' ? 'selected' : '' ?>>Autre</option>
</select>

<div id="gender-text" style="display: none;">
    <label for="gender-custom">Genre personnalisé :</label>
    <input type="text" name="gender_custom" id="gender-custom" value="<?= $user['gender'] === '2' ? htmlspecialchars($user['gender_custom']) : '' ?>">
</div>

<script>
    // Récupération des éléments HTML pertinents
    const genderSelect = document.getElementById('gender-select');
    const genderText = document.getElementById('gender-text');

    // Événement déclenché lorsqu'un nouvel élément est sélectionné dans la liste déroulante
    genderSelect.addEventListener('change', () => {
        // Si l'option "Autre" est sélectionnée, afficher le champ de texte, sinon le masquer
        if (genderSelect.value === '2') {
            genderText.style.display = 'block';
        } else {
            genderText.style.display = 'none';
        }
    });
</script> 

            </p>
            <p><label>Pays :</label> <input type="text" name="country" value="<?= htmlspecialchars($user['country']) ?>"></p>
             <p><label>Bio :</label> <textarea name="bio"><?= htmlspecialchars($user['bio']) ?></textarea></p>
        </div>
        <input type="submit" name="submit" value="Enregistrer les modifications">
        <br>
        <br>
<a href="logout.php">Se déconnecter</a>
<p>
    <a href="NewPassword.php">Changer de mot de passe</a>
    </form>
    <br>
    
</body>
</html>

<?php include "template/footer.php";?>
<?php include "codeLogs.php";?>

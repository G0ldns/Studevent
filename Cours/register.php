<?php session_start();
require "conf.inc.php";?>
<?php require "core/functions.php";?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="assets/Log PAsf.jpg" />
	<title>STUDEVENT</title>
	<link rel="stylesheet" type="text/css" href="register.css">
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
	<div class="container">
		<div class="row">
			<div class="col-12">

<!-- Boutons de navigation pour le formulaire -->

				<div id="button-container">
					<button id="previous" style="display: none;">⬅️</button>
					<button id="next">➡️</button>
				</div>

<!-- Logo et titre du formulaire d'inscription -->

				<center><img heigth="" src="assets/Log PAsf.jpg">
				<h1>Inscription</h1>
			</div>
		</div>

<!-- Affichage des erreurs si elles existent -->

		<?php if(isset($_SESSION['listOfErrors'])) {?>
		<div class="row">
			<div class="col-12">
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?php
					foreach ($_SESSION['listOfErrors'] as $error) {
						echo "<li>".$error."</li>";
					}
					unset($_SESSION['listOfErrors']);
					?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			</div>
		</div>
		<?php } ?> 

<!-- Début du formulaire d'inscription -->

		<form action="core/userAdd.php" method="POST">

<!-- Étape 1 : Genre, pseudo, prénom et nom -->

			<div id="step1">

<!-- Genre -->

				<div class="row mt-4">
					<div class="col-lg-12">
						<input type="radio" class="form-check-input" value="0"  <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["gender"]==0)?"checked":""; ?> name="gender" id="genderM">
						<label for="genderM" class="form-label"> M.</label> 
						<input type="radio" class="form-check-input" value="1" <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["gender"]==1)?"checked":""; ?> name="gender" id="genderMme">
						<label for="genderMme" class="form-label"> Mme. </label>
						<input type="radio" class="form-check-input" value="2" <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["gender"]==2)?"checked":""; ?> name="gender" id="genderO">
						<label for="genderO" class="form-label"> Autre</label>
					</div>
				</div>

<!-- Pseudo -->

					<div class="row mt-3">
				<div class="col-lg-6">
					<input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo" required="required" value="<?= ( !empty($_SESSION["data"]))?$_SESSION["data"]["pseudo"]:""; ?>">
				</div>

<!-- Prénom -->

					<div class="col-lg-6">
						<input type="text" class="form-control" name="firstname" placeholder="Votre prénom" required="required" value="<?= ( !empty($_SESSION["data"]))?$_SESSION["data"]["firstname"]:""; ?>">
					</div>

<!-- Nom -->

					<div class="col-lg-6">
						<input type="text" class="form-control" name="lastname" placeholder="Votre nom" required="required" value="<?= ( !empty($_SESSION["data"]))?$_SESSION["data"]["lastname"]:""; ?>">
					</div>
				</div>
			</div>
			
<!-- Étape 2 : Email et mot de passe -->

			<div id="step2" style="display: none;">
				<div class="row mt-3">
					<div class="col-lg-6">
						<!-- Email -->
						<input type="email" class="form-control" name="email" placeholder="Votre email" required="required" value="<?= ( !empty($_SESSION["data"]))?$_SESSION["data"]["email"]:""; ?>">
						<br><br>

<!-- Mot de passe -->

						<input type="password" class="form-control" name="pwd" placeholder="Votre mot de passe" required="required">
						<br><br>

<!-- Confirmation du mot de passe -->

						<input type="password" class="form-control" name="pwdConfirm" placeholder="Confirmation" required="required">
					</div>
				</div>
			</div>

<!-- Étape 3 : Pays et date de naissance -->

			<div id="step3" style="display: none;">
				<div class="row mt-3">
					<div class="col-lg-6">

<!-- Sélection du pays -->

						<select name="country"  class="form-select">
							<option value="fr" <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["country"]=="fr")?"selected":""; ?>>France</option>
							<option value="pl" <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["country"]=="pl")?"selected":""; ?>>Pologne</option>
							<option value="al" <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["country"]=="al")?"selected":""; ?>>Algérie</option>
							<option value="be" <?= ( !empty($_SESSION["data"]) && $_SESSION["data"]["country"]=="be")?"selected":""; ?>>Belgique</option>
						</select>
					</div>

<!-- Date de naissance -->

					<div class="col-lg-6">
						<input type="date" class="form-control" name="birthday" required="required" value="<?= ( !empty($_SESSION["data"]))?$_SESSION["data"]["birthday"]:""; ?>">
					</div>
				</div>



      
    
<!-- Acceptation des CGUs -->

				<div class="row mt-3">
					<div class="col-12">
						<center><input type="checkbox" class="form-check-input" id="cgu" name="cgu" required="required">
						<label for="cgu" class="form-label">J'accepte les CGUs</label>
					</div>
				</div>

<!-- Bouton d'inscription -->

        <div class="row mt-4">
            <div class="col-12">

<!-- Bouton d'inscription -->

						<center><input type="submit" value="S'inscrire" class="btn btn-primary">
					</div>
				</div>
			</div>

<!-- Lien vers la page de connexion -->

			<center><a href="login.php">S'identifier</a>
		</form>
	</div>
</body>
</html>

    	

<script>

var currentStep = 1;

document.getElementById('next').addEventListener('click', function() {
    document.getElementById('step' + currentStep).style.display = 'none';
    currentStep++;
    document.getElementById('step' + currentStep).style.display = 'block';

    if (currentStep === 3) {
        this.style.display = 'none';
    }

    if (currentStep > 1) {
        document.getElementById('previous').style.display = 'block';
    }
});

document.getElementById('previous').addEventListener('click', function() {
    document.getElementById('step' + currentStep).style.display = 'none';
    currentStep--;
    document.getElementById('step' + currentStep).style.display = 'block';

    if (currentStep === 1) {
        this.style.display = 'none';
    }

    if (currentStep < 3) {
        document.getElementById('next').style.display = 'block';
    }
});
</script>

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

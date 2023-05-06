<?php 
session_start();
require "conf.inc.php";
require "core/functions.php";
include "template/header.php";
include "search.php";

?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="" href="style.css">
     <style>
    h1 {
      text-align: center;
      font-size: 36px;
      color: #333;
    }

    p {
      font-size: 18px;
      line-height: 1.5;
      text-align: justify;
      padding: 0 20px;
    }
  </style>
</head>
<script>
	
// Fonction pour le POPUP de index
function closeMessageBox() {
    document.getElementById('messageBox').style.display = 'none';
}



</script>

<?php 

// POPUP qui s'affiche suite à la connexion et qui est fermable 
    if (isConnected()) {
        echo "
        <center>
	        <div id='messageBox' class='message-box'>

	            <p>Vous êtes connecté</p>
	            
	            <button onclick='closeMessageBox()'>

	            x
	            
	            </button>
	        </div>
       	</center>
        ";
    }

?>
	<h1>Welcome</h1>


	

	<p>Bienvenue sur STUDEVENT, le réseau social ultime pour les étudiants du monde entier! STUDEVENT est une plateforme qui vous permet de vous connecter avec d'autres étudiants, de partager vos expériences universitaires, de découvrir des événements et de participer à des discussions animées.
		<br>
		<br>

Notre plateforme est conçue pour les étudiants, par des étudiants. Nous comprenons les défis auxquels vous êtes confrontés au quotidien et c'est pourquoi nous avons créé un espace convivial où vous pouvez échanger avec d'autres étudiants, poser des questions, partager des idées et des conseils.
<br>
		<br>
STUDEVENT ne se limite pas à un simple réseau social, nous sommes également un blog d'événements qui couvre une variété de sujets allant des événements universitaires aux festivals de musique, en passant par les conférences et les opportunités de stages. Nous sommes là pour vous aider à rester informé et à ne rien manquer de ce qui se passe autour de vous.
<br>
		<br>
Rejoignez-nous dès maintenant et faites partie de la communauté STUDEVENT. Créez votre profil, ajoutez des amis, participez à des groupes de discussion, écrivez des articles et explorez notre vaste sélection d'événements. STUDEVENT est votre porte d'entrée vers une expérience étudiante enrichissante et inoubliable.</p>



<?php include "template/footer.php";?>
<?php include "codeLogs.php";?>


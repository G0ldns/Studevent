

<!--LOGS-->

<?php

//Récupérer $_SESSION['email'] = $email; par  $_GET['email'];la date

$month = "[".date("d")."/".date("m")."/".date("y")."] ";

//Récupérer l'heure

$hour = "[".date("H").":".date("i").":".date("s")."] ";

//Récupérer l'url
// $_SERVER['SERVER_NAME'] permet de récuper le nom du site
//$_SERVER['REMOTE_ADDR'] récupére l'adresse de la personne connecté

$url = $_SERVER['REMOTE_ADDR']." connect to ".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$email = 

// On réuni le tout

$logs = $month.$hour.$url."\n";

$files = fopen("logs.txt", "a+");
fputs($files ,$logs);
fclose($files);

?>
<?php 
session_start();
define("DB_PREFIX","esgi_");
define("DB_DATABASE","projet_web_1a2");
define("DB_USER","root");
define("DB_PWD","");
define("DB_PORT","3309");
define("DB_HOST","localhost");

try {
    $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";port=".DB_PORT,DB_USER, DB_PWD);
} catch(Exception $e){
    die("Erreur SQL ".$e->getMessage());
}
/// Récupérer le token depuis la chaîne de requête
$token = $_GET['token'];
echo "Token reçu : ".$token."<br>";

// Récupérer le token depuis la base de données
$queryPrepared = $connection->prepare("SELECT token FROM ".DB_PREFIX."user WHERE token = :token");
$queryPrepared->execute(["token"=>$token]);
$row = $queryPrepared->fetch();
$dbToken = $row['token'];
echo "Token en base de données : ".$dbToken."<br>";


// Vérifier si le token est valide et mettre à jour la colonne is_active
$queryPrepared = $connection->prepare("UPDATE ".DB_PREFIX."user SET is_active = 1 WHERE token = :token");
$queryPrepared->execute(["token"=>$token]);

// Afficher un message de confirmation à l'utilisateur
echo "Votre compte a été confirmé avec succès ! Vous pouvez maintenant vous connecter.";

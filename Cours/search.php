<?php
// Démarrer la session si elle n'a pas déjà été démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// inclure les fichiers nécessaires
require_once "conf.inc.php";
require_once "core/functions.php";
include_once "template/header.php";

// vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}

// afficher le formulaire de recherche
if (isset($_POST['search'])) {
    // exécuter la recherche et enregistrer les résultats dans une variable de session
    $search_query = $_POST['search_query'];
    $current_user_email = $_SESSION['email'];
    $connect = connectDB();
    $queryPrepared = $connect->prepare("SELECT * FROM ".DB_PREFIX."user WHERE pseudo LIKE :search_query AND email != :current_user_email");
    $queryPrepared->execute(['search_query' => '%' . $search_query . '%', 'current_user_email' => $current_user_email]);
    $results = $queryPrepared->fetchAll();

    // vérifier si des résultats ont été trouvés
    if (count($results) > 0) {
        // encoder les résultats au format JSON et enregistrer dans une variable de session
        $json_results = json_encode($results);
        $_SESSION['search_results'] = $json_results;
    } else {
        $_SESSION['search_results'] = "No results found.";
    }

    // rediriger l'utilisateur vers la page des résultats de recherche
    header("Location: searchUser.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="search.css">
</head>

<!-- Formulaire HTML avec la barre de recherche -->
<form method="post">
    <center><input type="text" name="search_query" placeholder="Recherche ..." >
    <input type="submit" name="search" value="Search"></center>
</form>



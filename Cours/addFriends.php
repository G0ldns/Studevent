<?php
session_start();
require "conf.inc.php";
require "core/functions.php";

$connect = connectDB();

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $envoyeur = $_SESSION['user_id']; // l'utilisateur connecté
    $receveur = $_GET['user_id']; // l'utilisateur dont l'ID est dans l'URL

    // On regarde si il existe déjà une demande

    $queryPrepared = $connect->prepare("SELECT * FROM friends WHERE (receveur = :envoyeur AND receveur = :receveur) OR (envoyeur = :receveur AND receveur = :envoyeur)");
    $queryPrepared->execute(["sender_id" => $envoyeur, "receiver_id" => $receveur]);
    $existingRequest = $queryPrepared->fetch();

    if (!$existingRequest) {

        // Ajout d'une demande d'ami dans la base de données
        $queryPrepared = $connect->prepare("INSERT INTO friends (envoyeur, receveur) VALUES (:envoyeur, :receveur)");
        $queryPrepared->execute(["sender_id" => $envoyeur, "receiver_id" => $receveur]);
        echo "Demande d'ami envoyée.";
    } else {
        echo "Une demande d'ami existe déjà entre ces utilisateurs.";
    }
}
?>

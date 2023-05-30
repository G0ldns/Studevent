<?php
session_start();
require "conf.inc.php";
require "core/functions.php";
include "template/header.php";

if(!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}
// Connexion à la base de données
$connect = connectDB();

// Récupération de l'ID de l'utilisateur connecté
$queryPrepared = $connect->prepare("SELECT id FROM ".DB_PREFIX."user WHERE email=:email");
$queryPrepared->execute(["email" => $_SESSION['email']]);
$id_demandeur = $queryPrepared->fetchColumn();




// Récupération de l'ID de l'utilisateur ($_Get = par l'url)
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Connexion à la base de données
    $connect = connectDB();

    // Requête pour récupérer les informations de l'utilisateur en fonction de l'ID
    $queryPrepared = $connect->prepare("SELECT pseudo, firstname, lastname, gender, country, bio FROM ".DB_PREFIX."user WHERE id=:id");
    $queryPrepared->execute(["id" => $user_id]);
    $user = $queryPrepared->fetch();
} else {
    echo "L'ID de l'utilisateur n'est pas défini.";
    exit;
}



// Si l'utilisateur soumet le formulaire de modification
if (isset($_POST['user-ajouter'])) {
    // Vérifier si l'utilisateur est connecté

    // Vérifier si la relation n'existe pas déjà
    $queryPrepared = $connect->prepare("SELECT COUNT(*) FROM relation WHERE id_demandeur=:id_demandeur AND id_receveur=:id_receveur");
    $queryPrepared->bindParam(':id_demandeur', $id_demandeur, PDO::PARAM_INT);
    $queryPrepared->bindParam(':id_receveur', $user_id, PDO::PARAM_INT);
    $queryPrepared->execute();
    $relationExists = $queryPrepared->fetchColumn();

    if (!$relationExists) {
        // Insérer la nouvelle relation
        $queryPrepared = $connect->prepare("INSERT INTO relation (id_demandeur, id_receveur, statut)
            VALUES (:id_demandeur, :id_receveur, :statut)");
        $queryPrepared->bindParam(':id_demandeur', $id_demandeur, PDO::PARAM_INT);
        $queryPrepared->bindParam(':id_receveur', $user_id, PDO::PARAM_INT);
        $queryPrepared->bindValue(':statut', 1, PDO::PARAM_INT);
        $queryPrepared->execute();
        $relationExists = true; // Mettre à jour la variable
    }
}

if (isset($_POST['user-supprimer'])) { 
    $id_supprimer = $_POST['user-supprimer'];
    $queryPrepared = $connect->prepare("DELETE FROM relation WHERE (id_demandeur=:id_demandeur AND id_receveur=:id_receveur) OR (id_demandeur=:id_receveur AND id_receveur=:id_demandeur)");
    // Correction : Inversion des variables $id_demandeur et $user_id
$queryPrepared->bindParam(':id_demandeur', $user_id, PDO::PARAM_INT);
$queryPrepared->bindParam(':id_receveur', $id_demandeur, PDO::PARAM_INT);

    $queryPrepared->execute();
    $relationExists = false; // Mettre à jour la variable
}

if (isset($_POST['user-bloquer'])) {
    // Vérifier si la relation existe
    $queryPrepared = $connect->prepare("SELECT COUNT(*) FROM relation WHERE id_demandeur=:id_demandeur AND id_receveur=:id_receveur");
    $queryPrepared->bindParam(':id_demandeur', $id_demandeur, PDO::PARAM_INT);
    $queryPrepared->bindParam(':id_receveur', $user_id, PDO::PARAM_INT);
    $queryPrepared->execute();
    $relationExists = $queryPrepared->fetchColumn();

if ($relationExists) {
    // Mettre à jour la relation existante
    // Mettre à jour la relation existante
    $queryPrepared = $connect->prepare("UPDATE relation SET statut = :statut, id_bloqueur = :id_bloqueur WHERE (id_demandeur=:id_demandeur AND id_receveur=:id_receveur) OR (id_demandeur=:id_receveur AND id_receveur=:id_demandeur)");
    $queryPrepared->bindParam(':id_demandeur', $id_demandeur, PDO::PARAM_INT);
    $queryPrepared->bindParam(':id_receveur', $user_id, PDO::PARAM_INT);
    $queryPrepared->bindValue(':statut', 3, PDO::PARAM_INT);
    $queryPrepared->bindValue(':id_bloqueur', $user_id, PDO::PARAM_INT);
    $queryPrepared->execute();
    $relationExists = true;

}

}elseif (isset($_POST['user-debloquer'])) {
    // Supprimer la relation bloquée
    $queryPrepared = $connect->prepare("DELETE FROM relation WHERE id_demandeur=:id_demandeur AND id_receveur=:id_receveur AND statut=:statut");
    $queryPrepared->bindParam(':id_demandeur', $id_demandeur, PDO::PARAM_INT);
    $queryPrepared->bindParam(':id_receveur', $user_id, PDO::PARAM_INT);
    $queryPrepared->bindValue(':statut', 3, PDO::PARAM_INT);
    $queryPrepared->execute();
    $relationExists = false; // Mettre à jour la variable
}




// ...
$relationExists = false;
$queryPrepared = $connect->prepare("SELECT statut FROM relation WHERE id_demandeur=:id_demandeur AND id_receveur=:id_receveur");
$queryPrepared->bindParam(':id_demandeur', $id_demandeur, PDO::PARAM_INT);
$queryPrepared->bindParam(':id_receveur', $user_id, PDO::PARAM_INT);
$queryPrepared->execute();
$statut = $queryPrepared->fetchColumn();
if ($statut == 1) {
    $relationExists = true;
}



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
    <br>
    <br>
    <br>
    <form>

        <div class="user-info">
            <p><label>Pseudo :</label> <input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>" readonly></p>

            <p>
                <label>Prénom :</label> <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" readonly>
            </p>

            <p
            ><label>Nom :</label> <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" readonly>
            </p>

            <p>
                <label>Genre :</label> <input type="text" name="gender" value="<?= htmlspecialchars($user['gender']) ?>" readonly>
            </p>

            <p>
                <label>Pays :</label> <input type="text" name="country" value="<?= htmlspecialchars($user['country']) ?>" readonly>
            </p>

            <p>
                <label>Bio :</label> <textarea name="bio" readonly><?= htmlspecialchars($user['bio']) ?></textarea>
            </p>

        </div>
    </form>
        <div>
            
        </div>

        <?php
$relationExists = false;
$queryPrepared = $connect->prepare("SELECT statut FROM relation WHERE id_demandeur=:id_demandeur AND id_receveur=:id_receveur");
$queryPrepared->bindParam(':id_demandeur', $user_id, PDO::PARAM_INT);
$queryPrepared->bindParam(':id_receveur', $id_demandeur, PDO::PARAM_INT);
$queryPrepared->execute();
$statut = $queryPrepared->fetchColumn();
if ($statut == 1) {
    $relationExists = true;
    echo "Vous avez reçu une demande d'amis";
}
?>



<!-- ... code précédent ... -->


<form method="post">
    <?php
    $action = '';
    if (isset($_POST['user-ajouter'])) {
        $action = 'Ajouter';
    } elseif (isset($_POST['user-supprimer'])) {
        $action = 'Supprimer';
    } elseif (isset($_POST['user-bloquer'])) {
        $action = 'Bloquer';
    } elseif (isset($_POST['user-debloquer'])) {
        $action = 'Débloquer';
    }

    if ($relationExists) {
        // Si la relation existe, afficher les boutons Supprimer et Bloquer
        switch ($action) {
            case '':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
            case 'Ajouter':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
            case 'Supprimer':
                echo '<input type="submit" name="user-debloquer" value="Débloquer">';
                break;
            case 'Bloquer':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-debloquer" value="Débloquer">';
                break;
            case 'Débloquer':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
        }
    } else {
        // Si la relation n'existe pas, afficher les boutons Ajouter et Bloquer
        switch ($action) {
            case '':
                echo '<input type="submit" name="user-ajouter" value="Ajouter">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
            case 'Ajouter':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
            case 'Supprimer':
                echo '<input type="submit" name="user-ajouter" value="Ajouter">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
            case 'Bloquer':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-debloquer" value="Débloquer">';
                break;
            case 'Débloquer':
                echo '<input type="submit" name="user-supprimer" value="Supprimer">';
                echo '<input type="submit" name="user-bloquer" value="Bloquer">';
                break;
        }
    }
    ?>
</form>


<!-- ... code suivant ... -->




</body>
</html>

<?php include "template/footer.php";?>
<?php include "codeLogs.php";?>






<?php
session_start();
include "template/headerAdmin.php";
require "core/conf.inc.admin.php";


$conn = connectDB();

// Vérifier si un téléchargement de fichier est demandé
if (isset($_GET['download'])) {
    $fileId = $_GET['download'];

    // Requête SQL pour récupérer le fichier depuis la base de données
    $stmt = $conn->prepare("SELECT nom, contenu, type FROM fichiers WHERE id = :id");
    $stmt->bindParam(':id', $fileId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $fileUniqueName = $row['nom'];
        $fileContent = $row['contenu'];
        $fileType = $row['type'];

        // Envoyer les en-têtes appropriés pour le téléchargement du fichier
        header('Content-Type: ' . $fileType);
        header('Content-Disposition: attachment; filename="' . $fileUniqueName . '"');
        header('Content-Length: ' . strlen($fileContent));

        // Envoyer le contenu du fichier au navigateur
        echo $fileContent;
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichiers']) && is_array($_FILES['fichiers']['tmp_name'])) {
    // Traitement de l'upload des fichiers
    foreach ($_FILES['fichiers']['tmp_name'] as $key => $tmp_name) {
        if (!empty($_FILES['fichiers']['name'][$key])) {
            $fileName = $_FILES['fichiers']['name'][$key];
            $fileTmp = $_FILES['fichiers']['tmp_name'][$key];
            $fileType = $_FILES['fichiers']['type'][$key];

            // Générer un nom de fichier unique pour éviter les collisions
            $fileUniqueName = uniqid() . '_' . $fileName;

            // Lecture du contenu du fichier
            $fileContent = file_get_contents($fileTmp);

            // Requête préparée pour insérer le fichier dans la base de données
            $stmt = $conn->prepare("INSERT INTO fichiers (nom, contenu, type) VALUES (:nom, :contenu, :type)");
            $stmt->bindParam(':nom', $fileUniqueName);
            $stmt->bindParam(':contenu', $fileContent, PDO::PARAM_LOB);
            $stmt->bindParam(':type', $fileType);
            $stmt->execute();

            echo 'Le fichier ' . $fileName . ' a été uploadé avec succès.<br>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page d'administration</title>
  <style type="text/css">
        body {
            background-color: #3E2F23;
            color: #FFF;
            text-align: center;
        }

        .file-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #644F3E;
            margin: 20px;
            border-radius: 5px;
        }

        .file-container img,
        .file-container video {
            width: 300px;
            height: auto;
            margin: 10px;
        }

        .file-container a {
            color: #FFF;
            text-decoration: none;
        }

        .file-container button {
            background-color: #FFF;
            color: #644F3E;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="fichiers">Sélectionnez les fichiers à uploader :</label><br>
        <input type="file" name="fichiers[]" id="fichiers" multiple><br>
        <input type="submit" value="Uploader">
    </form>

    <h2>Fichiers uploadés :</h2>
    <?php
    // Vérification si le formulaire de suppression a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteFile'])) {
        $fileId = $_POST['deleteFile'];

        // Requête SQL pour supprimer le fichier de la base de données
        $stmtDelete = $conn->prepare("DELETE FROM fichiers WHERE id = :Id");
        $stmtDelete->bindParam(':Id', $fileId);
        $stmtDelete->execute();

        // Suppression réussie
        echo 'Le fichier a été supprimé avec succès.<br>';
    }

    // Requête SQL pour récupérer les fichiers depuis la base de données
    $sql = "SELECT * FROM fichiers";
    $stmt = $conn->query($sql);
  ?>
  <div class="file-container">
  <?php
    // Afficher les fichiers
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fileId = $row['id'];
        $fileUniqueName = $row['nom'];
        $fileType = $row['type'];

        echo '<div>';

        if (strpos($fileType, 'image') === 0) {
            // Afficher l'image directement
            echo '<img src="data:' . $fileType . ';base64,' . base64_encode($row['contenu']) . '" alt="Aperçu de l\'image"><br>';
        } elseif (strpos($fileType, 'video') === 0) {
            // Afficher la vidéo
            echo '<video controls>';
            echo '<source src="data:' . $fileType . ';base64,' . base64_encode($row['contenu']) . '" type="' . $fileType . '">';
            echo 'Votre navigateur ne prend pas en charge la lecture de vidéos.';
            echo '</video><br>';
        } elseif ($fileType === 'application/pdf') {
            // Afficher le lien de téléchargement pour les fichiers PDF
            echo '<a href="imageAdmin.php?download=' . $fileId . '">' . $fileUniqueName . '</a><br>';
        } else {
            // Afficher le nom du fichier pour les autres types de fichiers
            echo basename($fileUniqueName) . '<br>';
        }

        // Bouton de suppression
        echo '<form method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer ce fichier ?\')">';
        echo '<input type="hidden" name="deleteFile" value="' . $fileId . '">';
        echo '<button type="submit">Supprimer</button>';
        echo '</form>';

        echo '</div><br>';
    }

    $conn = null;
    ?>
        </div>
    <?php include "template/footerAdmin.php";?>
</body>
</html>

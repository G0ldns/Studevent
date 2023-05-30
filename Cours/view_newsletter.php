<?php
session_start();
require "core/conf.inc.admin.php";

// Vérifier si l'identifiant de la newsletter est passé dans l'URL
if (isset($_GET['newsletter_id'])) {
    $newsletterId = $_GET['newsletter_id'];
    
    // Connexion à la base de données
    $conn = connectDB();
    
    // Récupération des informations de la newsletter
    $sql = "SELECT * FROM gestion_newsletter WHERE id = :newsletterId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':newsletterId', $newsletterId);
    $stmt->execute();
    $newsletter = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifier si la newsletter existe
    if (!$newsletter) {
        echo "Newsletter non trouvée.";
        exit;
    }
    
    // Afficher les informations de la newsletter
    echo "<h2>".$newsletter['subject']."</h2>";
    echo "<p>".$newsletter['content']."</p>";
} else {
    echo "Identifiant de newsletter manquant.";
}
?>

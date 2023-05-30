<?php
session_start();
include "template/headerAdmin.php";
require "core/conf.inc.admin.php";

$conn = connectDB();

// Suppression d'un abonné
if (isset($_GET['delete'])) {
    $subscriberId = $_GET['delete'];

    // Supprimer l'abonné de la base de données
    $sql = "DELETE FROM newsletter WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $subscriberId);
    
}

// Récupération de tous les abonnés
$sqlSubscribers = "SELECT * FROM newsletter";
$stmtSubscribers = $conn->prepare($sqlSubscribers);
$stmtSubscribers->execute();
$subscribers = $stmtSubscribers->fetchAll(PDO::FETCH_ASSOC);

echo "<section>";
echo "<hr>";
echo "<b><h3>Abonnés</h3></b>";
if (count($subscribers) > 0) {
    echo "<table border='1px' style='width: 100%;'>
            <tr>
                <th>ID</th>
                <th>Adresse e-mail</th>
                <th>Date de création</th>
                <th>Action</th>
            </tr>";
    foreach ($subscribers as $subscriber) {
        echo "<tr>
                <td>".$subscriber["id"]."</td>
                <td>".$subscriber["email"]."</td>
                <td>".$subscriber["created_at"]."</td>
                <td><a href='?delete=".$subscriber["id"]."'>Supprimer</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Aucun abonné trouvé.";
}
echo "</section>";

// Création d'une newsletter
if (isset($_POST['create'])) {
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    // Enregistrer la newsletter dans la base de données
    $sql = "INSERT INTO gestion_newsletter (subject, content, created_at) VALUES (:subject, :content, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':content', $content);

}

// Récupération de toutes les newsletters
$sqlNewsletters = "SELECT * FROM gestion_newsletter";
$stmtNewsletters = $conn->prepare($sqlNewsletters);
$stmtNewsletters->execute();
$newsletters = $stmtNewsletters->fetchAll(PDO::FETCH_ASSOC);

echo "<hr>";
?>

<form method="post" action="">
   <center><label for="subject">Sujet de la newsletter :</label><br>
    <input type="text" id="subject" name="subject" required></center><br><br>
    <center><label for="content">Contenu de la newsletter :</label><br>
    <textarea id="content" name="content" rows="5" style="width: 100%;" required></textarea><br><br>
    <input type="submit" name="create" value="Créer la newsletter"></center>
</form>

<?php
echo "<section>";
echo "<hr>";
echo "<b><h3>Newsletters</h3></b>";
if (count($newsletters) > 0) {
    echo "<table border='1px' style='width: 100%;'>
            <tr>
                <th>ID</th>
                <th>Sujet</th>
                <th>Contenu</th>
                <th>Date de création</th>
                <th>Action</th>
            </tr>";
    foreach ($newsletters as $newsletter) {
        echo "<tr>
                <td>".$newsletter["id"]."</td>
                <td>".$newsletter["subject"]."</td>
                <td>".$newsletter["content"]."</td>
                <td>".$newsletter["created_at"]."</td>
                <td>
                    <a href='send_newsletter.php?newsletter_id=".$newsletter["id"]."'>Envoyer</a>
                    <a href='view_newsletter.php?newsletter_id=".$newsletter["id"]."'>Voir</a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Aucune newsletter trouvée.";
}
echo "</section>";
echo "<hr>";
$conn = null;
?>



<?php include "template/footerAdmin.php";?>
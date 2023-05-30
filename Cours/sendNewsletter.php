<?php
session_start();
require "core/PHPMailer/PHPMailerAutoload.php";
require 'core/PHPMailer/class.phpmailer.php';
require 'core/PHPMailer/class.smtp.php';
require "conf.inc.php";
require "core/functions.php";

$connect = connectDB();
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

// récupère la liste de la base de données
$stmt = $connect->query("SELECT email FROM newsletter");

// boucle while pour envoyer les e-mails à tous les utilisateurs
while ($subscriber = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'studevent.officiel@gmail.com';
        $mail->Password = 'sblxxnsotixbycxj';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('studevent.officiel@gmail.com', 'STUDEVENT CONTACT');
        $mail->addAddress($subscriber['email'], $subscriber['firstname'] . ' ' . $subscriber['lastname']);
        $mail->isHTML(true);
        $mail->Subject = $newsletter['subject'];
        $mail->Body = $newsletter['content'];

        $mail->send();
    } catch (Exception $e) {
        // Gérer les exceptions ici
    }
}

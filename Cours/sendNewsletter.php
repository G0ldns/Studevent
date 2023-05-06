<?php
session_start();
require "core/PHPMailer/PHPMailerAutoload.php";
require 'core/PHPMailer/class.phpmailer.php';
require 'core/PHPMailer/class.smtp.php';
require "conf.inc.php";
require "core/functions.php";
include "template/header.php";

$connect = connectDB();

// Get the user's details
$queryPrepared = $connect->prepare("SELECT email, firstname, lastname, pseudo FROM ".DB_PREFIX."user WHERE email=:email");
$queryPrepared->execute(["email"=>$_SESSION['email']]);
$user = $queryPrepared->fetch();

// If the user has submitted the subscription form
if (isset($_POST['newsletter'])) {
    // Get the form data
    $email = $_POST['email'];

    // Check if the email is already subscribed
    $stmt = $connect->prepare("SELECT COUNT(*) FROM newsletter WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if ($result > 0) {
        // Show a message that the email is already subscribed
        echo "This email is already subscribed!";
    } else {
        // Insert the subscriber details into the database
        $stmt = $connect->prepare("INSERT INTO newsletter (email) VALUES (:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Show a success message
        echo "Thank you for subscribing!";
    }
}

// If the user has submitted the unsubscription form
if (isset($_POST['unsubscribe'])) {
    // Get the form data
    $email = $_POST['email'];

    // Delete the subscriber from the database
    $stmt = $connect->prepare("DELETE FROM newsletter WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Show a success message
    echo "You have been unsubscribed!";
}

// Get the list of subscribers from the database
$stmt = $connect->query("SELECT email FROM newsletter");

// Loop through the results and send emails to subscribers
while ($subscriber = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $mail = new PHPMailer(true);

     try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'studvent.contact@gmail.com';
        $mail->Password = 'ypxawlkusqxjjyxa';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('studvent.contact@gmail.com', 'studevent contact');
        $mail->addAddress($subscriber['email'], $subscriber['firstname'] . ' ' . $subscriber['lastname']);
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre inscription';
        $mail->Body = '<p>Bonjour ' . $subscriber['pseudo'] . ',</p>
                       <p>Veuillez cliquer sur le lien suivant pour confirmer votre inscription :</p>
                       <p><a href="https://www.example.com/confirm.php?email=' . $subscriber['email'] . '">https://www.example.com/confirm.php?email=' . $subscriber['email'] . '</a></p>
                       <p>A bientôt sur notre site !</p>';

        $mail->send();
    } catch (Exception $e) {
        // Handle exceptions here
    }
}
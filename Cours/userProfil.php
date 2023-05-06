<?php
session_start();
require "conf.inc.php";
require "core/functions.php";
include "template/header.php";

// Récupérez l'ID de l'utilisateur à partir de l'URL
$user_id = $_GET['user_id'];

// Connexion à la base de données
$connect = connectDB();

// Requête pour récupérer les informations de l'utilisateur en fonction de l'ID
$queryPrepared = $connect->prepare("SELECT pseudo, firstname, lastname, gender, country, bio FROM ".DB_PREFIX."user WHERE id=:id");
$queryPrepared->execute(["id" => $user_id]);
$user = $queryPrepared->fetch();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil de <?= htmlspecialchars($user['pseudo']) ?></title>
    <link rel="stylesheet" type="" href="profil.css">
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
  <?php // Vérifier si l'utilisateur est connecté
  $email = $_SESSION['email'];

if(isset($_SESSION['login'])) {

    // Récupérer la liste des amis de l'utilisateur connecté
    $queryPrepared = $connect->prepare("SELECT friend_email FROM ".DB_PREFIX."user WHERE user_email=:email");
    $queryPrepared->execute(["email"=>$email]);
    $friends = $queryPrepared->fetchAll(PDO::FETCH_COLUMN);

    // Afficher un formulaire pour ajouter un ami
    echo "<form method='POST'>";
    echo "<input type='email' name='add_friend_email' placeholder='Email de l\'ami'>";
    echo "<button type='submit'>Ajouter un ami</button>";
    echo "</form>";

    // Afficher la liste des amis de l'utilisateur connecté
    echo "<ul>";
    foreach($friends as $friend) {
        // Récupérer le nom de l'ami à partir de son email
        $queryPrepared = $connect->prepare("SELECT name FROM ".DB_PREFIX."user WHERE email=:email");
        $queryPrepared->execute(["email"=>$friend]);
        $friend_name = $queryPrepared->fetchColumn();

        // Afficher le nom de l'ami et un bouton pour le supprimer
        echo "<li>$friend_name";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='remove_friend_email' value='$friend'>";
        echo "<button type='submit'>Supprimer l'ami</button>";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
}
?>

</body>
</html>

<?php include "template/footer.php";?>
<?php include "codeLogs.php";?>

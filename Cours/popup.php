<?php


// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    // Vérifier si l'utilisateur n'a pas encore vu la popup
    if (!isset($_COOKIE['popup_displayed'])) {
        // Afficher la popup
        echo '<script type="text/javascript">
                if(confirm("Voulez-vous vous abonner à notre newsletter ?")){
                    window.location.href = "newsletter.php";
                }else{
                    setcookie("popup_displayed", "true", time() + 3600 * 24 * 30);
                }
            </script>';
    }
}

// Gérer la soumission du formulaire d'abonnement
if (isset($_POST['subscribe']) && $_POST['subscribe'] == 'true') {
    // Enregistrer l'abonnement de l'utilisateur dans la base de données
    $connect = connectDB();
    $queryPrepared = $connect->prepare("UPDATE ".DB_PREFIX."user SET newsletter=1 WHERE id=:id");
    $queryPrepared->execute(["id"=>$_SESSION['user_id']]);
    // Mettre à jour la variable de session
    $_SESSION['newsletter'] = true;
    // Rediriger l'utilisateur vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>

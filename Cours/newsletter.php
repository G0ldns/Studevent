<?php
    session_start();
    require "conf.inc.php";
    require "core/functions.php";
    include "template/header.php";
// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}


if(isset($_POST['subscribe'])) {

  
    $connect = connectDB();
    $queryPrepared = $connect->prepare("SELECT email FROM ".DB_PREFIX."user WHERE email=:email");
    $queryPrepared->execute(["email"=>$_SESSION['email']]);
    $results = $queryPrepared->fetch();

   
    $queryPrepared = $connect->prepare("SELECT COUNT(*) FROM newsletter WHERE email=:email");
    $queryPrepared->execute(["email"=>$results["email"]]);
    $count = $queryPrepared->fetchColumn();

    if($count > 0) {
      
        echo "<script type='text/javascript'>alert('Vous êtes déjà inscrit à la newsletter.');</script>";
    } else {   

        $queryPrepared = $connect->prepare("INSERT INTO newsletter (email) VALUES (:email)");
        $queryPrepared->execute(["email"=>$results["email"]]);
        
        echo "<script type='text/javascript'>alert('Vous êtes maintenant inscrit à la newsletter.');</script>";
    }
}



    if(isset($_POST['unsubscribe'])){
        $email = $_SESSION['email'];

       
        $connect = connectDB();
        $queryPrepared = $connect->prepare("DELETE FROM newsletter WHERE email=:email");
        $queryPrepared->execute(["email"=>$email]);

      echo "<script type='text/javascript'>alert('Vous êtes désabonner de la newsletter.');</script>";
    }

    
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STUDEVENT</title>
    <style type="text/css">
 /* Centrer le formulaire */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

/* Ajouter de l'espace entre les boutons */
button {
    margin: 10px;
}

/* Styliser les boutons */
button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}

/* Styliser le formulaire */
form {
    background-color: #f2f2f2;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
}

/* Styliser le titre du formulaire */
form h2 {
    text-align: center;
    font-size: 24px;
    margin-top: 0px;
}

/* Styliser l'image */
img {
    max-width: 100%;
    height: auto;
}

/* Styliser le lien vers l'envoi de newsletter */
a {
    display: block;
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
}


    </style>
</head>
<body>

<div class="">
    <div class="row">
        <div>
            <form method="POST">
                <center><img heigth="" src="assets/Log PAsf.jpg"></center>
                <br>
                <br>

                <div class="advice">
                <h2>Conseils de révision et événements à venir pour les étudiants</h2>
                <p>Chers étudiants, n'oubliez pas de bien organiser votre temps de révision en vue des examens finaux. Planifiez des sessions de révision régulières pour chaque matière et utilisez des méthodes efficaces telles que la mémorisation active et la répétition espacée.</p>
                <p>De plus, nous avons plusieurs événements passionnants prévus dans les semaines à venir, notamment une conférence sur l'entrepreneuriat et une soirée de networking pour les étudiants en informatique. Des sorties en boite Restez à l'écoute pour plus de détails et n'hésitez pas à vous inscrire si vous êtes intéressé.</p>
            </div>


                <a href="sendNewsletter.php">Envoyer la newsletter</a>
                <button  type="submit" name="subscribe">S'abonner</button>
                <br>
                <br>
            </form>
            <form method='POST'>
                    <button name='unsubscribe'>Se désabonner</button>
            </form>
        </div>
    </div>
</div>


</div>
</body>
</html>


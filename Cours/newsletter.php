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
</head>
<body>


<div class="">
    <div class="row">
        <div class="col-12">
            <form method="POST">
                <center><img heigth="" src="assets/Log PAsf.jpg"></center>
                <br>
                <br>
                <br>
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


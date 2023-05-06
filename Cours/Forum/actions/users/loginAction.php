<?php
session_start();
require('actions/database.php');

//Validation du formulaire
if(isset($_POST['validate'])){

    //Vérifier si l'user a bien complété tous les champs
    if(!empty($_POST['email']) AND !empty($_POST['pwd'])){
        
        //Les données de l'user
        $email = htmlspecialchars($_POST['email']);
        $pwd = htmlspecialchars($_POST['pwd']);

        //Vérifier si l'utilisateur existe (si le email est correct)
        $checkIfUserExists = $bdd->prepare('SELECT * FROM esgi_user WHERE email = ?');
        $checkIfUserExists->execute(array($email));

        if($checkIfUserExists->rowCount() > 0){
            
            //Récupérer les données de l'utilisateur
            $esgi_userInfos = $checkIfUserExists->fetch();

            //Vérifier si le mot de passe est correct
            if(pwd_verify($pwd, $esgi_userInfos['mdp'])){
            
                //Authentifier l'utilisateur sur le site et récupérer ses données dans des variables globales sessions
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $esgi_userInfos['id'];
                $_SESSION['lastname'] = $esgi_userInfos['nom'];
                $_SESSION['firstname'] = $esgi_userInfos['prenom'];
                $_SESSION['email'] = $esgi_userInfos['email'];

                //Rediriger l'utilisateur vers la page d'accueil
                header('Location: index.php');
    
            }else{
                $errorMsg = "Votre mot de passe est incorrect...";
            }

        }else{
            $errorMsg = "Votre email est incorrect...";
        }

    }else{
        $errorMsg = "Veuillez compléter tous les champs...";
    }

}
<?php

require('actions/database.php');

//Récupérer l'identifiant de l'utilisateur
if(isset($_GET['id']) AND !empty($_GET['id'])){

    //L'id de l'utilisateur
    $idOfUser = $_GET['id'];

    //Vérifier si l'utilisateur existe
    $checkIfUserExists = $bdd->prepare('SELECT pseudo, lastname, firstname FROM ".DB_PREFIX."user WHERE id = ?');
    $checkIfUserExists->execute(array($idOfUser));

    if($checkIfUserExists->rowCount() > 0){
        
        //Récupérer toutes les données de l'utilisateur
        $usersInfos = $checkIfUserExists->fetch();

        $user_pseudo = $usersInfos['pseudo'];
        $user_lastname = $usersInfos['lastname'];
        $user_firstname = $usersInfos['firstname'];

        //Récupérer toutes les questions publiées par l'utilisateur
        $getHisQuestions = $bdd->prepare('SELECT * FROM questions WHERE id_auteur = ? ORDER BY id DESC');
        $getHisQuestions->execute(array($idOfUser));

    }else{
        $errorMsg = "Aucun utilisateur trouvé";
    }

}else{
    $errorMsg = "Aucun utilisateur trouvé";
}
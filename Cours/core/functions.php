<?php

function helloWorld(){
	echo "Hello World";
}

function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Admin

function isAdmin($user) {
    return $user['role'] === 'admin';
}

// Prénom

function cleanFirstname($firstName){
	return ucwords(strtolower(trim($firstName)));
}

// Nom

function cleanLastname($lastName){
	return strtoupper(trim($lastName));
}

// EMAIL 

function cleanEmail($email){
	return strtolower(trim($email));
}

// PSEUDO 

function cleanPseudo($pseudo){
    return trim($pseudo);
}

// Connexion à la DB

function connectDB(){

	try{
		$connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";port=".DB_PORT,DB_USER, DB_PWD);
	}catch(Exception $e){
		die("Erreur SQL ".$e->getMessage());
	}
	return $connection;
}



function isConnected(){
	if(!empty($_SESSION['email']) && !empty($_SESSION['login'])){

		$connection = connectDB();
		$queryPrepared = $connection->prepare("SELECT id FROM ".DB_PREFIX."user where email=:email");
		$queryPrepared->execute(["email"=>$_SESSION['email']]);
		$result = $queryPrepared->fetch();

		if(!empty($result)){
			return true;
		}
		
	}
	return false;
}

function redirectIfNotConnected(){
	if(!isConnected()){
		header("Location: login.php");
	}
}

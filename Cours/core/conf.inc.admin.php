<?php

define("DB_PREFIX","esgi_");
define("DB_DATABASE","projet_web_1a2");
define("DB_USER","root");
define("DB_PWD","");
define("DB_PORT","3309");
define("DB_HOST","localhost");

function connectDB(){

	try{
		$connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";port=".DB_PORT,DB_USER, DB_PWD);
	}catch(Exception $e){
		die("Erreur SQL ".$e->getMessage());
	}
	return $connection;
}
?>
<?php
session_start();
require "../conf.inc.php";
require "functions.php";

require "PHPMailer/PHPMailerAutoload.php"; 
require 'PHPMailer/class.phpmailer.php';
require 'PHPMailer/class.smtp.php';

//Vérification des données

// Vérifier que les champs obligatoires existent et non sont pas vides
// FAILLE XSS
if( count($_POST) !=10
    || !isset($_POST['gender'])
    || empty($_POST['firstname'])
    || empty($_POST['lastname'])
    || empty($_POST['pseudo'])
    || empty($_POST['email'])
    || empty($_POST['pwd'])
    || empty($_POST['pwdConfirm'])
    || empty($_POST['country'])
    || empty($_POST['birthday'])
   // || empty($_POST['token']) 
    || empty($_POST['cgu'])

){
    die ("Tentative de HACK");
}



//Nettoyage des données
$pseudo = cleanPseudo($_POST['pseudo']);
$gender = $_POST['gender'];
$firstname = cleanFirstname($_POST['firstname']);
$lastname = cleanLastname($_POST['lastname']);
$email = cleanEmail($_POST['email']);
$pwd = $_POST['pwd'];
$pwdConfirm = $_POST['pwdConfirm'];
$country = $_POST['country'];
$birthday = $_POST['birthday'];
$cgu = $_POST['cgu'];
//$captcha = $_POST['captcha'];



$listOfErrors = [];

// --> Est-ce que le pseudo est cohérent
if(strlen($pseudo) < 3 || strlen($pseudo) > 20){
    $listOfErrors[] = "Le pseudo doit contenir entre 3 et 20 caractères";
}else{
	$connection = connectDB();
	$queryPrepared = $connection->prepare("SELECT * FROM ".DB_PREFIX."user WHERE pseudo=:pseudo");
	$queryPrepared->execute([ "pseudo" => $pseudo ]);

	$results = $queryPrepared->fetch();

	if(!empty($results)){
		$listOfErrors[] = "Le pseudo est déjà utilisé";
	}

}

// --> Est-ce que le genre est cohérent
$listGenders = [0,1,2];
if( !in_array($gender, $listGenders) ){
	$listOfErrors[] = "Le genre n'existe pas";
}
// --> Nom plus de 2 caractères
if(strlen($lastname) < 2){
	$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
}

// --> Prénom plus de 2 caractères
// --> Nom plus de 2 caractères
if(strlen($firstname) < 2){
	$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
}
// --> Format de l'email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	$listOfErrors[] = "L'email est incorrect";
}else{
	// --> Unicité de l'email (plus tard)
	$connection = connectDB();
	$queryPrepared = $connection->prepare("SELECT * FROM ".DB_PREFIX."user WHERE email=:email");
	$queryPrepared->execute([ "email" => $email ]);

	$results = $queryPrepared->fetch();

	if(!empty($results)){
		$listOfErrors[] = "L'email est déjà utilisé";
	}

}


// --> Complexité du pwd
if(strlen($pwd) < 8
 || !preg_match("#[a-z]#", $pwd)
 || !preg_match("#[A-Z]#", $pwd)
 || !preg_match("#[0-9]#", $pwd)){
	$listOfErrors[] = "Le mot de passe doit faire au min 8 caractères avec des minuscules, des majuscules et des chiffres";
}


// --> Meme mot de passe de confirmation
if( $pwd != $pwdConfirm){
	$listOfErrors[] = "La confirmation du mot de passe ne correspond pas";
}

// --> Est-ce que le pays est cohérent
$listCountries = ["fr", "pl", "al", "be"];
if( !in_array($country, $listCountries) ){
	$listOfErrors[] = "Le pays n'existe pas";
}


// --> Date de naissance entre 6ans et 99ans

//$birthday = "1986-11-29";

$birthdayExploded = explode("-", $birthday);
//Vérification de la date
if (!checkdate($birthdayExploded[1],$birthdayExploded[2],$birthdayExploded[0])){
	$listOfErrors[] = "Date de naissance incorrecte";
}else{
	//Vérification de l'age
	$todaySecond = time();
	$birthdaySecond = strtotime($birthday);
	$ageSecond = $todaySecond - $birthdaySecond;
	$age = $ageSecond/60/60/24/365.25;
	if( $age <= 6 || $age >= 99 ){
		$listOfErrors[] = "Vous n'avez pas l'âge requis (entre 6 et 99 ans)";
	}
}

	// Generate a unique token for the user
$token = bin2hex(random_bytes(16));

/*if($captcha != $_SESSION['captcha']){
	$listOfErrors[] = "Le captcha ne correspond pas";
}*/


//Si OK
if(empty($listOfErrors)){

//Insertion en BDD

	$queryPrepared = $connection->prepare("INSERT INTO ".DB_PREFIX."user
                                        (gender, firstname, lastname, pseudo, email, pwd, birthday, country,token,is_active)
                                        VALUES 
                                        (:gender, :firstname, :lastname, :pseudo, :email, :pwd, :birthday, :country, :token, 0)");



// Envoi du mail de confirmation
$mail = new PHPMailer(true); // create a new object
try {

    $mail->SMTPDebug = 0; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'studvent.contact@gmail.com'; // SMTP username
    $mail->Password = 'ypxawlkusqxjjyxa'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    $mail->setFrom('studvent.contact@gmail.com', 'studevent contact');
    $mail->addAddress($email, $firstname . ' ' . $lastname); // Add a recipient
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Confirmation de votre inscription';
    $mail->Body = '<p>Bonjour ' . $pseudo . ',</p>
                   <p>Veuillez cliquer sur le lien suivant pour confirmer votre inscription :</p>
			  
			<p><a href="http://localhost/projet%20WEB%201A2/Cours/core/confirm.php?token=' . $token . '">Activation</a></p>




                   <p>A bientôt sur notre site !</p>';
    
    $mail->send();
    echo 'Un email de confirmation a été envoyé à l\'adresse ' . $email . '. Veuillez cliquer sur le lien dans l\'email pour confirmer votre inscription.';
} catch (Exception $e) {
    echo 'Une erreur est survenue lors de l\'envoi de l\'email : ' . $mail->ErrorInfo;
}


		$queryPrepared->execute([
		                            "gender"=>$gender,
		                            "firstname"=>$firstname,
		                            "lastname"=>$lastname,
		                            "pseudo"=>$pseudo,
		                            "email"=>$email,
		                            "pwd"=>password_hash($pwd, PASSWORD_DEFAULT),
		                            "birthday"=>$birthday,
		                            "country"=>$country,
		                            "token"=>$token
		                        ]);



	//Redirection sur la page de connexion
	header('location: ../login.php');

}else{

	//Si NOK
	//On stock les erreurs et la data
	$_SESSION['listOfErrors'] = $listOfErrors;
	unset($_POST["pwd"]);
	unset($_POST["pwdConfirm"]);
	$_SESSION['data'] = $_POST;
	//Redirection sur la page d'inscription
	header('location: ../register.php');
}



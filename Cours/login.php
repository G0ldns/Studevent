<?php
    session_start();
    require "conf.inc.php";
    require "core/functions.php";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="assets/Log PAsf.jpg" />
    <title>STUDEVENT</title>
    <link rel="stylesheet" type="" href="login.css">
</head>
<body>

<div class="">
    <?php
    // On va vérifier que l'on a quelque chose dans $_POST
    // Ce qui signifie que le formulaire a été validé
    if( !empty($_POST['email']) &&  !empty($_POST['pwd']) ){

        $email = cleanEmail($_POST["email"]);
        $pwd = $_POST["pwd"];

        // Vérifier si le compte est activé
        $connect = connectDB();
        $queryPrepared = $connect->prepare("SELECT is_active FROM ".DB_PREFIX."user WHERE email=:email");
        $queryPrepared->execute(["email"=>$email]);
        $results = $queryPrepared->fetch();

        if(!empty($results) && $results["is_active"] == 1 ){

            // Récupérer en bdd le mot de passe hashé pour l'email
            // provenant du formulaire
            $queryPrepared = $connect->prepare("SELECT pwd FROM ".DB_PREFIX."user WHERE email=:email");
            $queryPrepared->execute(["email"=>$email]);
            $results = $queryPrepared->fetch();

            if(!empty($results) && password_verify($pwd, $results["pwd"]) ){
                $_SESSION['email'] = $email;
                $_SESSION['login'] = true;
                header("Location: index.php");
            }else{
                echo "<script type='text/javascript'>alert('Identifiants incorrects');</script>";
            }

        } else {
            echo "<script type='text/javascript'>alert('Votre compte n'est pas activé');</script>";
        }

    }
?>


    <div class="row">
        <div class="col-12">
            <form method="POST">

                    <center><img heigth="" src="assets/Log PAsf.jpg">
                <br>
                <br>
                <br>

                <input type="email" name="email" placeholder="Votre email" required="required">
                <input type="password" name="pwd" placeholder="Mot de passe"required="required">
                <button>Se connecter</button>
                <br>
                <br>

                <center><a href="register.php">S'incrire</a><br><a href="forgot_password/changePwd.php">Mot de passe oublié ?</a>
            </form>
        </div>
    </div>
</div>
</body>

</html>



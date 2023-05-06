<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="assets/Log PAsf.jpg" />
	<title>STUDEVENT</title>
	<meta name="description" content="super site en php">
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">STUDEVENT</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        
        

        <?php if (!isConnected()){ ?>

        <li class="nav-item">
          <a class="nav-link" href="login.php">Se connecter</a>
        </li>

      <?php } else { ?>

        <li class="nav-item">
          <a class="nav-link" href="profil.php">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">Liste des utilisateurs</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="#">Evenement</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Forum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="NewPassword.php">Changer mot de passe</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="newsletter.php">Newsletter</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="logout.php">Se déconnecter</a>
        </li>



      <?php } ?>


      </ul>
    </div>
  </div>
</nav>

<?php

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $current_user_email = $_SESSION['email'];
    $connect = connectDB();
    $queryPrepared = $connect->prepare("SELECT * FROM ".DB_PREFIX."user WHERE pseudo LIKE :search_query AND email != :current_user_email");
    $queryPrepared->execute(['search_query' => '%' . $search_query . '%', 'current_user_email' => $current_user_email]);
    $results = $queryPrepared->fetchAll();

    // check if any results were found
    if (count($results) > 0) {
        // encode the results in JSON format
        $json_results = json_encode($results);
        // set a session variable to hold the search results
        $_SESSION['search_results'] = $json_results;
    } else {
        $_SESSION['search_results'] = "aucun résultat.";
    }

    // redirect the user to rechercheUser.php
    header("Location: rechercheUser.php");
    exit();
}

$pdo = null;

?>

<!-- HTML form with the search bar -->
<form method="post">
    <center><input type="text" name="search_query">
    <input type="submit" name="search" value="Search"></center>
</form>

    </div>
  </div>
</nav>



<div class="container">
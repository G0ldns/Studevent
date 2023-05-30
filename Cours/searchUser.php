<?php 
session_start();
require "conf.inc.php";
require "core/functions.php";
include "template/header.php";
include "search.php";

?>
<!DOCTYPE html>
<html>
<head>
<style>
        
        body {
    font-family: Centaur;
    background-color: beige;
    padding: 30px;
}

h1 {

    font-family: Bernard MT;

}

    </style>
</head>

<?php

// vérifiez si la variable de session contenant les résultats de recherche est définie et non vide

if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])) {

// convertir la chaîne JSON stockée dans la variable de session en tableau associatif
    $results = json_decode($_SESSION['search_results'], true);

// afficher les résultats de recherche
    echo "<ul>";
    foreach ($results as $row) {
        echo "<li><a href='userProfil.php?user_id=" . $row['id'] . "'>" . $row['pseudo'] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "Aucun résultat trouvé.";
}
?>

<?php include "template/footer.php";?>
<?php include "codeLogs.php";?>


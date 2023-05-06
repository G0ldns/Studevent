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
        $_SESSION['search_results'] = "No results found.";
    }

    // redirect the user to rechercheUser.php
    header("Location: searchUser.php");
    exit();
}

$pdo = null;

?>

<!-- HTML form with the search bar -->
<form method="post">
    <center><input type="text" name="search_query">
    <input type="submit" name="search" value="Search"></center>
</form>
<!DOCTYPE html>
<html>
<head>
  <title>Barre de recherche dynamique AJAX</title>
  <script>
    function searchUsers() {
      var searchValue = document.getElementById('searchInput').value;

      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'search.php?query=' + searchValue, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var users = JSON.parse(xhr.responseText);
          displaySearchResults(users);
        }
      };
      xhr.send();
    }

    function displaySearchResults(users) {
      var searchResults = document.getElementById('searchResults');
      searchResults.innerHTML = '';

      if (users.length === 0) {
        var listItem = document.createElement('li');
        listItem.appendChild(document.createTextNode('Aucun utilisateur trouvé.'));
        searchResults.appendChild(listItem);
      } else {
        users.forEach(function(user) {
          var listItem = document.createElement('li');
          listItem.appendChild(document.createTextNode(user.username));
          searchResults.appendChild(listItem);
        });
      }
    }
  </script>
</head>
<body>
  <h1>Recherche d'utilisateurs</h1>
  <input type="text" id="searchInput" placeholder="Rechercher un utilisateur" onkeyup="searchUsers()">
  <ul id="searchResults"></ul>
</body>
</html>

<?php
// search.php

// Récupérer la valeur de recherche depuis la requête GET
$searchQuery = $_GET['query'];

// Effectuer la recherche dans votre base de données ou autre source de données
// et renvoyer les utilisateurs correspondants au format JSON
$users = performSearch($searchQuery);
echo json_encode($users);

function performSearch($searchQuery) {
  // Effectuer votre logique de recherche ici
  // et renvoyer les utilisateurs correspondants
  // (par exemple, requête à la base de données, appel à une API, etc.)
  // Dans cet exemple, renvoyons simplement un tableau statique de résultats fictifs

  $users = array(
    array('username' => 'Utilisateur1'),
    array('username' => 'Utilisateur2'),
    array('username' => 'Utilisateur3'),
  );

  return $users;
}
?>

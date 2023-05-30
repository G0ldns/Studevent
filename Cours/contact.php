<?php
session_start(); 
require "conf.inc.php";
require 'core/functions.php';
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
<body>

<div class="container">
    <div class="container mt-5">
        <h1>Contactez vos amis</h1>
        <div class="row">
            <div class="col-md-4">
                <h2>Liste des contacts</h2>
                <ul class="list-group">
                    <li class="list-group-item">Ami 1</li>
                    <li class="list-group-item">Ami 2</li>
                    <li class="list-group-item">Ami 3</li>
                    <li class="list-group-item">Ami 4</li>
                    <li class="list-group-item">Ami 5</li>
                </ul>
            </div>

            <div class="col-md-8">
                <h2>Envoyer un message</h2>
                <form action="send_message.php" method="post">
                    <div class="form-group">

                        <label for="contact">Sélectionnez un contact :</label>
                        <select class="form-control" id="contact" name="contact">
                            <option value="ami1">Ami 1</option>
                            <option value="ami2">Ami 2</option>
                            <option value="ami3">Ami 3</option>
                            <option value="ami4">Ami 4</option>
                            <option value="ami5">Ami 5</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message :</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>

<?php include "template/footer.php";?>
<?php include "codeLogs.php";?>

<?php 
    session_start();
    require('actions/questions/showAllQuestionsAction.php');
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="includes/css/index-style.css" />
    </head>
    <body>
        <main>
            <?php include 'includes/navbar.php';?>
            <div class="index-bg"></div>
            <div class="container">
                <form method="GET">
                    <div class="form-group row">
                        <input type="search" name="search" class="search-input">
                        <button class="search-button" type="submit">Rechercher</button>
                    </div>
                </form>
                <?php while($question = $getAllQuestions->fetch()): ?>
                    <div class="card">
                        <div class="card-header question-header">
                            <a href="article.php?id=<?= $question['id']; ?>">
                                <?= $question['titre']; ?>
                            </a>
                        </div>
                        <div class="card-body question-body">
                            <?= $question['description']; ?>
                        </div>
                        <div class="card-footer question-footer">
                            Publié par 
                            <a href="profile.php?id=<?= $question['id_auteur']; ?>">
                                <?= $question['pseudo_auteur']; ?>
                            </a> le <?= $question['date_publication']; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>    
    </body>
</html>
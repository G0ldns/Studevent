<link rel="stylesheet" href="includes/css/components.css" />
<link rel="stylesheet" href="includes/css/header.css" />

<div class="header-wrapper">
    <div class="header">

        <div class="header-left">

            <div class="header-tab" onclick="window.location.href=''">
                <a lang-id="hed_dash" dashboard>Forum</a>
            </div>

            <div class="header-tab" onclick="window.location.href='publish-question.php'">
                <a lang-id="hed_qna">Publier une question</a>
            </div>

            <div class="header-tab" onclick="window.location.href='my-questions.php'">
                <a>Mes questions</a>
            </div>

        </div>

        <div class="header-right">
              <?php 
                if(isset($_SESSION['auth'])){
                  ?>
                    <a class="third-button" href="profile.php?id=<?= $_SESSION['id']; ?>">Mon profil</a>
                    <a class="nav-link" href="actions/users/logoutAction.php">Déconnexion</a>
                  <?php
                }
              ?>
        </div>

    </div>
</div>
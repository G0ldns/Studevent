<!DOCTYPE html>
<html>
<head>
  <style>
/* Start Variables */ 
:root {
    --hair-color: #424b54;
    --skin-color: #f0beaf;
}
/* End Variables */ 

/* Start Global Rules */
body {
    background-color: #ebd8d0;
}
.human {
    margin: auto;
    background-color: #f0beaf;
    width: 220px;
    height: 220px;
    border: 3px solid #fff;
    border-radius: 50%;
    position: relative;
    overflow: hidden;
}

.hair {
    background-color: var(--hair-color);
    width: 120px;
    height: 100px;
    position: absolute;
    top: 40px;
    left: 110px;
    transform: translateX(-50%);
    border-top-right-radius: 80px;
    border-top-left-radius: 80px;
    z-index: 1;
}
.napkin {
    content: "";
    background-color: var(--hair-color);
    width: 60px;
    height: 40px;
    position: absolute;
    top: -24px;
    left: -5px;
    box-shadow: 40px 10px 0 -8px var(--hair-color);
    border-radius: 50s%;
}
.face {
    background-color: var(--skin-color);
    width: 70px;
    height: 80px;
    position: absolute;
    top: 80px;
    left: 50px;
    transform: translateX(35%);
    z-index: 1;
    border-radius: 0 0 80px 80px;
    border: 1px solid black; /* Ajout du contour noir */
}


.eye {
    background-color: black;
    width: 10px;
    height: 10px;
    position: absolute;
    top: 27px;
    left: 8px;
    box-shadow: 42px 0 0 black;
    border-radius: 50%;
}
.brow {
    position: absolute;
    top: -5px;
    left: -1px;
    width: 12px;
    height: 2px;
    background: #626f7d;
    box-shadow: 42px 0 0 #626f7d;
    border-radius: 10px;
}
.nose {
    background-color: #db9b99;
    width: 8px;
    height: 16px;
    position: absolute;
    top: 28px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 12px;
}

.cheek {
    position: absolute;
    bottom: 30px;
    left: 5px;
    width: 10px;
    height: 7px;
    border-radius: 50%;
    background-color: #eba8a8;
    box-shadow: 48px 0 0 #eba8a8;
}

.mouth {
    position: absolute;
    top: 52px;
    left: 50%;
    transform: translateX(-50%);
    width: 28px;
    height: 14px;
    background-color: black;
    border-radius: 0 0 20px 20px;
    overflow: hidden;
}

.teeth {
    background-color: #fff;
    width: 25px;
    height: 2px;
    position: absolute;
    top: 0px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 10px;
}

.tongue{
    background-color: red;
    width: 18px;
    height: 8px;
    position: absolute;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 10px;
}

.neck {
    background-color: var(--skin-color);
    width: 27px;
    height: 15px;
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    margin-top: 80px; /* Ajout de la marge pour positionner le cou correctement */
    border-radius: 50px;
    border: 1px solid black; /* Ajout du contour noir */
}
.body {
    background-color: #bb004f;
    width: 98px;
    height: 80px;
    position: absolute;
    bottom: -22px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    border-top-left-radius: 50px;
    border-top-right-radius: 50px;
}
/* End Drawing */ 

/* Start Avatar Controls */
.controls {
    margin-top: 20px;
}

.control-group {
    margin-bottom: 10px;
}

.control-label {
    display: block;
    font-weight: bold;
}

.control-input {
    width: 100%;
    padding: 5px;
}

.control-color {
    width: 100px;
    height: 30px;
}

.control-button {
    margin-top: 10px;
}
/* End Avatar Controls */ 

  </style>
</head>
<body>
<div class="human">
    <div class="hair"></div>
    <div class="face">
        <div class="napkin"></div>
        <div class="eye">
            <div class="brow"></div>
        </div>
        <div class="nose"></div>
        <div class="cheek"></div>
        <div class="mouth">
            <div class="teeth"></div>
            <div class="tongue"></div>
        </div>
        <div class="neck"></div> <!-- Ajout du cou -->
    </div>
    <div class="body"></div>
</div>




    <div class="controls">
        <div class="control-group">
            <label for="hair-color-input" class="control-label">Couleur des cheveux:</label>
            <input type="color" id="hair-color-input" class="control-input">
        </div>
        <div class="control-group">
            <label for="hairstyle-select" class="control-label">Coiffure:</label>
            <select id="hairstyle-select" class="control-input">
                <option value="long">Long</option>
                <option value="short">Court</option>
                <option value="bun">Chignon</option>
            </select>
        </div>
        <button id="update-avatar-button" class="control-button">Mettre à jour l'avatar</button>
    </div>

    <script>
        // Récupérer les éléments de contrôle
        const hairColorInput = document.getElementById('hair-color-input');
        const hairstyleSelect = document.getElementById('hairstyle-select');
        const updateAvatarButton = document.getElementById('update-avatar-button');
        const hairElement = document.querySelector('.hair');

        // Mettre à jour la couleur des cheveux
        hairColorInput.addEventListener('change', function () {
            document.documentElement.style.setProperty('--hair-color', this.value);
        });

        // Mettre à jour la coupe de cheveux
        hairstyleSelect.addEventListener('change', function () {
            // Réinitialiser les classes de coupe de cheveux
            hairElement.classList.remove('long', 'short', 'bun');

            // Appliquer la classe de coupe de cheveux sélectionnée
            hairElement.classList.add(this.value);
        });

        // Mettre à jour l'avatar lorsque le bouton est cliqué
        updateAvatarButton.addEventListener('click', function () {
            // Mettre à jour l'avatar selon les nouvelles valeurs
            const hairColor = hairColorInput.value;
            const hairstyle = hairstyleSelect.value;

            // Mettre à jour la couleur des cheveux
            document.documentElement.style.setProperty('--hair-color', hairColor);

            // Mettre à jour la coupe de cheveux
            hairElement.classList.remove('long', 'short', 'bun');
            hairElement.classList.add(hairstyle);

            // Exemple: Afficher les valeurs actuelles pour vérification
            console.log('Couleur des cheveux:', hairColor);
            console.log('Coiffure:', hairstyle);
        });
    </script>
</body>
</html>

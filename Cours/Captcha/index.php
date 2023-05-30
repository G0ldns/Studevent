<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Captcha Puzzle</title>
        <link rel="stylesheet" href="puzzle.css">
        <script src="puzzle.js"></script>
    </head>
    <body>
      <br>
      <div id="board"></div>
      <h1>Temps: <span id="temps">30</span>s</h1>
      <div id="pieces"></div>
      <div class="changeTheme" id="themeBtn">Dark Mode</div>
      
      <script>
        var temps = 30;
        var timer = setInterval(function() {
          temps--;
          document.getElementById("temps").innerHTML = temps;
          if (temps == 0) {
            clearInterval(timer);
            alert("Le temps est écoulé !");
            location.reload();
          }
        }, 1000);
  
        var isDarkMode = false;
        var themeBtn = document.getElementById("themeBtn");
        themeBtn.addEventListener("click", function() {
          isDarkMode = !isDarkMode;
          if (isDarkMode) {
            document.body.classList.add("dark");
            themeBtn.innerHTML = "Light Mode";
          } else {
            document.body.classList.remove("dark");
            themeBtn.innerHTML = "Dark Mode";
          }
        });
      </script>
      
  </body>
  </html>  

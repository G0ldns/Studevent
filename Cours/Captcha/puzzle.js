var rows = 3;
var columns = 3;

var currTile;
var otherTile;

var temps = 0;


window.onload = function() {
    //initialize the 3x3 board
    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < columns; c++) {
            let tile = document.createElement("img");
            tile.src = "./images/blank.jpg";

            //DRAG FUNCTIONALITY
            tile.addEventListener("dragstart", dragStart); //click on image to drag
            tile.addEventListener("dragover", dragOver);   //drag an image
            tile.addEventListener("dragenter", dragEnter); //dragging an image into another one
            tile.addEventListener("dragleave", dragLeave); //dragging an image away from another one
            tile.addEventListener("drop", dragDrop);       //drop an image onto another one
            tile.addEventListener("dragend", dragEnd);      //after you completed dragDrop

            document.getElementById("board").append(tile);
        }
        
    }

    const switchThemeBtn = document.querySelector('.changeTheme')
    let toggleTheme = 0;
    

    switchThemeBtn.addEventListener('click', () => {

        if(toggleTheme === 0) {

            document.documentElement.style.setProperty('--ecriture', '#262626');
            document.documentElement.style.setProperty('--background', '#f1f1f1');
            toggleTheme++;

        } else {

            document.documentElement.style.setProperty('--ecriture', '#f1f1f1');
            document.documentElement.style.setProperty('--background', '#262626');
            toggleTheme--;

        }


    })

    //pieces
    let pieces = [];
    for (let i=1; i <= rows*columns; i++) {
        pieces.push(i.toString()); //put "1" to "" into the array (puzzle images names)
    }
    pieces.reverse();
    for (let i =0; i < pieces.length; i++) {
        let j = Math.floor(Math.random() * pieces.length);

        //swap
        let tmp = pieces[i];
        pieces[i] = pieces[j];
        pieces[j] = tmp;
    }

    for (let i = 0; i < pieces.length; i++) {
        let tile = document.createElement("img");
        tile.src = "./images/" + pieces[i] + ".jpg";

        //DRAG FUNCTIONALITY
        tile.addEventListener("dragstart", dragStart); //click on image to drag
        tile.addEventListener("dragover", dragOver);   //drag an image
        tile.addEventListener("dragenter", dragEnter); //dragging an image into another one
        tile.addEventListener("dragleave", dragLeave); //dragging an image away from another one
        tile.addEventListener("drop", dragDrop);       //drop an image onto another one
        tile.addEventListener("dragend", dragEnd);      //after you completed dragDrop

        document.getElementById("pieces").append(tile);
    }
    
}

//DRAG TILES
function dragStart() {
    currTile = this; //this refers to image that was clicked on for dragging
}

function dragOver(e) {
    e.preventDefault();
}

function dragEnter(e) {
    e.preventDefault();
}

function dragLeave() {

}

function dragDrop() {
    otherTile = this; //this refers to image that is being dropped on
}

function validateCaptcha() {
    alert("Captcha validé !");
}


function dragEnd() {
    console.log("dragEnd() called");
    if (currTile.src.includes("blank")) {
        return;
    }
    let currImg = currTile.src;
    let otherImg = otherTile.src;
    currTile.src = otherImg;
    otherTile.src = currImg;
    
    //check if the puzzle is solved
    let puzzleSolved = true;
    let tiles = document.querySelectorAll("#board img");
    for (let i = 0; i < tiles.length; i++) {
        let tileNum = parseInt(tiles[i].src.split("/").pop().split(".")[0]);
        if (tileNum !== i+1) {
            puzzleSolved = false;
            break;
        }
    }
    
    //display message if puzzle is solved
    if (puzzleSolved) {
        alert("Félicitations, vous avez réussi à résoudre le puzzle !");
        window.location.href = "../login.php";    }   
}

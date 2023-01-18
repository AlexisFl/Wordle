

//déclaration de la taille de la grille
var t_base = 400;

//position dans la grille
var row = 0;
var col = 0;

//etat du jeu
var gameOver = false;

var temp = document.getElementById("score").innerHTML;

temp = temp.split(":");

score = parseInt(temp[1]);


//liste des mots à deviner et ceux possible à rentrer (les mots de la base de donnée) 
//var wordList = ["pommes","porter","guigui","tables","rideau","chaise","prison"];
//let wordList = [];
//wordList = wordList.concat(t);


//tirage du mot à deviner
//var word = wordList[Math.floor(Math.random()*wordList.length)].toUpperCase();
var word = squid.toUpperCase();
var nb_lettres = nb_diff;
console.log(word);
initialise_taille(word);

let lCount = {};
for (let j = 0; j<word.length; j++){
    let le = word[j];
    if(lCount[le]){
        lCount[le]+=1;
    }
    else{
        lCount[le] = 1;
    }
}
let nb_lettres_diff = Object.keys(lCount).length;

//déclaration de la taille de la grille
var height = 6;
var width = word.length;

//lorsque la page est chargé on lance la fonction initialize
window.onload = function(){
    initialize();
}



function initialize(){
    // creation des case en leur donnant un id row-col et en leur attribuant la class tile, il seront les descendant de div "board"
    for (let i = 0; i < height; i++){
        for (let j = 0; j < width; j++){
            let tile = document.createElement("span");
            tile.id = i.toString()+ "-"+ j.toString();
            tile.classList.add("tile");
            tile.innerText = " ";
            document.getElementById("board").appendChild(tile);
        }
    }

    //déclaration du clavier manuel
    let keyboard =[
        ["A","Z","E","R","T","Y","U","I","O","P"],
        ["Q","S","D","F","G","H","J","K","L","M"],
        ["Enter","W","X","C","V","B","N","⌫"]
    ];



    for (let i = 0; i< keyboard.length; i++){
        //on créer un div pour chaque ligne du clavier
        let currRow = keyboard[i];
        let keyboardRow = document.createElement("div");
        keyboardRow.classList.add("keyboard-row");


        //pour chaque ligne du clavier on créer un div pour chaque touche en attribuant un id et une class key-tile
        //on effectue les exceptions pour entrer et supprimer
        for(let j = 0; j < currRow.length; j++){
            let keyTile = document.createElement("div");
            let key = currRow[j];
            keyTile.innerText = key;
            if (key == "Enter"){
                keyTile.id = "Enter";
            }
            else if (key == "⌫"){
                keyTile.id = "Backspace";
            }
            else if ("B" <= key && key <= "L"){
                keyTile.id = "Key" + key;
            }
            else if (key == "A"){
                keyTile.id = "Key" + "Q";
            }
            else if (key == "Q"){
                keyTile.id = "Key" + "A";
            }
            else if (key == "Z"){
                keyTile.id = "Key" + "W";
            }
            else if (key == "W"){
                keyTile.id = "Key" + "Z";
            }
            else if (key == ","){
                keyTile.id = "Key" + "M";
                console.log("ici on choisit la virgule");
                console.log(keyTile.id);
            }
            else if (key == "M"){
                keyTile.id = "Key" + "M";
                console.log("ici on choisit le M");
                console.log(keyTile.id);
            }
            else if ("N" <= key && key <= "P"){
                keyTile.id = "Key" + key;
            }
            else if ("R" <= key && key <= "V"){
                keyTile.id = "Key" + key;
            }
            else if ("X" <= key && key <= "Y"){
                keyTile.id = "Key" + key;
            }

            keyTile.addEventListener("click",processKey);

            if (key == "Enter"){
                keyTile.classList.add("enter-key-tile");
            }
            else if (key == "⌫"){
                keyTile.classList.add("backspace-key-tile");
            }
            else{
                keyTile.classList.add("key-tile");
            }
            keyboardRow.appendChild(keyTile);
        }
        document.body.appendChild(keyboardRow);
    }
    console.log("nous sommes à la fin du initialize");

    document.addEventListener("keyup", (e) => {
        if (e.key == 'a'){
            console.log(e);
            e.code = "KeyA";
            console.log(e.key);
        }
        console.log("e : " + e);
        console.log("e.code :" + e.code);
        processInput(e);
    })
}

//on associe à e l'id keyD si D... et on apelle processInput de la touche choisit
function processKey(){
    e = {"code" : this.id};
    console.log("e : " + e.code);
    processInput(e);
}

function processInput(e){
    //si fini on return
    if(gameOver) return;

    //on verifie si la touche choisit est une lettre ou une touche de controle (entrer ou suppr)
    //on va récupérer la dernière lettre de l'id de la touche du clavier (ce qui correspond à la lettre en majuscule)
    if("KeyA" <= e.code && e.code <= "KeyZ"){
        if(col < width){
            if(e.code == "KeyA"){
                let currTile = document.getElementById(row.toString() + "-" + col.toString());
                if(currTile.innerText == ""){
                    currTile.innerText = "Q";
                    console.log("on est ici");
                    col+=1;
                }
            }
            else if(e.code == "KeyQ"){
                let currTile = document.getElementById(row.toString() + "-" + col.toString());
                if(currTile.innerText == ""){
                    currTile.innerText = "A";
                    console.log("on est ici");
                    col+=1;
                }
            }
            else if(e.code == "KeyZ"){
                let currTile = document.getElementById(row.toString() + "-" + col.toString());
                if(currTile.innerText == ""){
                    currTile.innerText = "W";
                    console.log("on est ici");
                    col+=1;
                }
            }
            else if(e.code == "KeyW"){
                let currTile = document.getElementById(row.toString() + "-" + col.toString());
                if(currTile.innerText == ""){
                    currTile.innerText = "Z";
                    console.log("on est ici");
                    col+=1;
                }
            }
            else if(e.code == "KeyM"){
                let currTile = document.getElementById(row.toString() + "-" + col.toString());
                if(currTile.innerText == ""){
                    currTile.innerText = "M";
                    console.log("on est ici");
                    col+=1;
                }
            }
            else{
                let currTile = document.getElementById(row.toString() + "-" + col.toString());
                if(currTile.innerText == ""){
                    currTile.innerText = e.code[3];
                    console.log("on est ici");
                    col+=1;
                }
            }
        }
    }
    //si la touche choisi est le suppr on retire la lettre en reculant d'une colonne
    else if (e.code == "Backspace"){
        if(0 < col && col <= width){
            col -= 1;
        }
        let currTile = document.getElementById(row.toString()+'-'+col.toString());
        currTile.innerText = "";
    }
    //si la touhe choisit est entrer on appelle la fonction update
    else if(e.code == "Enter" && word.length == col){
        update();
    }

    else if(e.code == "Semicolon"){
        let currTile = document.getElementById(row.toString() + "-" + col.toString());
        if(currTile.innerText == ""){
            currTile.innerText = "M";
            console.log("on est ici");
            col+=1;
        }
    }
    //si le tableau est plein l'etat du jeu passe a true (gameover)
    if(!gameOver && row == height){
        gameOver = true;
        window.location.href = "play.php?score=100";

        document.getElementById("answer").innerText = word;
    }
}

function update(){
    //creation des variables necessaire, le mot et la reponse
    let guess = "";
    document.getElementById("answer").innerText = "";

    //on recupere les lettre que l'on ajoute a la variable guess qui correspond au mot propose par l'utilisateur
    for (let i = 0; i < width; i++){
        let currTile = document.getElementById(row.toString()+'-'+i.toString());
        console.log("currtile :" + currTile.innerText);
        let letter = currTile.innerText;
        console.log("letter " + letter);
        guess += letter;
        console.log("longueur " + guess.length);
    }
    console.log("nous sommesau guess");
    guess = guess.toLowerCase();
    console.log(guess);

    //on verifie que le mot est valable comme essaie
    if(!valide(guess)){
        document.getElementById("answer").innerText = "Not in word list";
        return;
    }

    //compte le nombre d'occurence de chaque lettre
    let correct = 0;
    let letterCount = {};
    for (let j = 0; j<word.length; j++){
        let letter = word[j];
        if(letterCount[letter]){
            letterCount[letter]+=1;
        }
        else{
            letterCount[letter] = 1;
        }
    }
    console.log(letterCount);


    //on verifie si le mot est trouve ou non, pour passer l'etat du jeu a fini
    //on ajoute la valeur present a notre class de case si la lettre est bonne
    for (let k = 0; k < width; k++){
        console.log(document.getElementById(row.toString()+'-'+k.toString()).innerText);
        let currTile = document.getElementById(row.toString()+'-'+k.toString());
        let letter = currTile.innerText;

        if(word[k] == letter){
            currTile.classList.add("correct");

            let keyTile = document.getElementById("Key" + letter);
            if(letter == "Q"){
                keymo = document.getElementById("KeyA");
                keymo.classList.remove("present");
                keymo.classList.add("correct");
            }
            else if(letter == "A"){
                keymo = document.getElementById("KeyQ");
                keymo.classList.remove("present");
                keymo.classList.add("correct");
            }
            else if(letter == "W"){
                keymo = document.getElementById("KeyZ");
                keymo.classList.remove("present");
                keymo.classList.add("correct");
            }
            else if(letter == "Z"){
                keymo = document.getElementById("KeyW");
                keymo.classList.remove("present");
                keymo.classList.add("correct");
            }
            else{
                keyTile.classList.remove("present");
                keyTile.classList.add("correct");
            }
            correct+=1;
            letterCount[letter] -= 1;
        }
        if(correct == width){
            gameOver = true;
            score = score + correct * 100;
            score = score + nb_lettres * 100;
            score = score - row * 100;
            score_mdj = 1000 - (row * 100);
            console.log(score_mdj);
            let scor = document.getElementById("score");
            let res_score="";
            res_score = "Score : " + String(score);
            console.log(res_score);
            scor.innerHTML = res_score;
            console.log(window.location.href.includes("level"));
            if(window.location.href.includes("level")){
                if(window.location.href == "play.php?score=0"){
                    window.location.href = "play.php?&score=" + String(score);
                 
                    res_score = "Score : " + String(score);
                    console.log(res_score);
                    scor.innerHTML = res_score;
                }
                else if(correct < 7){
                    window.location.href = "play.php?level=1&score=" + String(score);
                   
                    res_score = "Score : " + String(score);
                    console.log(res_score);
                    scor.innerHTML = res_score;
                }
                else if(correct > 7 && correct < 9){
                    window.location.href = "play.php?level=2&score=" + String(score);
                   
                    res_score = "Score : " + String(score);
                    console.log(res_score);
                    scor.innerHTML = res_score;
                }
                else{
                    window.location.href = "play.php?level=3&score=" + String(score);
                    
                    res_score = "Score : " + String(score);
                    console.log(res_score);
                    scor.innerHTML = res_score;
                }
            }
            else{
                res_score = "Score : " + String(score_mdj);
                console.log(res_score);
                scor.innerHTML = res_score;
                window.location.href = "play.php?score=" + String(score_mdj);
            }
        }
    }

    console.log("letter count : " + letterCount);

    for (l = 0; l < width; l++){
        let currTile = document.getElementById(row.toString()+'-'+l.toString());
        let letter = currTile.innerText;

        if(!currTile.classList.contains("correct")){
            if(word.includes(letter) && letterCount[letter]>0){
                currTile.classList.add("present");

                let keyTile = document.getElementById("Key"+ letter);
                console.log("keytile : " + keyTile);
                console.log("keytile class : " + keyTile.classList);
                console.log("letter : " + letter);
                if(!keyTile.classList.contains("correct")){
                    if (letter == "A"){
                        keym = document.getElementById("KeyQ");
                        keym.classList.add("present");
                    }
                    else if(letter == "Q"){
                        keym = document.getElementById("KeyA");
                        keym.classList.add("present");
                    }
                    else if(letter == "Z"){
                        keym = document.getElementById("KeyW");
                        keym.classList.add("present");
                    }
                    else if(letter == "W"){
                        keym = document.getElementById("KeyZ");
                        keym.classList.add("present");
                    }
                    else {
                        keyTile.classList.add("present");
                    }
                }
                letterCount[letter] -= 1;
            }
            else{
                currTile.classList.add("absent");
                let keyTile = document.getElementById("Key" + letter);
                console.log("keytile : " + keyTile);
                console.log("keytile class : " + keyTile.classList);
                console.log("letter : " + letter);
                if(letter == "A"){
                    keym = document.getElementById("KeyQ");
                    keym.classList.add("absent");
                }
                else if(letter == "Q"){
                    keym = document.getElementById("KeyA");
                    keym.classList.add("absent");
                }
                else if(letter == "Z"){
                    keym = document.getElementById("KeyW");
                    keym.classList.add("absent");
                }
                else if(letter == "W"){
                    keym = document.getElementById("KeyZ");
                    keym.classList.add("absent");
                }
                else{
                    keyTile.classList.add("absent");
                }
            }
        }
    }
    row += 1;
    col = 0;
    console.log("nous sommes à la fin du update");
}

//Changer la taille de la grille en focntion de la taille du mot
function initialise_taille(mot){
    var nb = mot.length - 5;
    if(mot.length == 5){
        t_base = 350;
    }
    else if(mot.length == 6){
        t_base = 400;
    }
    else if(mot.length > 6 && mot.length < 9){
        t_base = t_base + (nb * 58);
    }
    else if (mot.length == 16){
        t_base = t_base + (nb * 62);
    }
    else if (mot.length >= 17){
        t_base = t_base + (nb * 63);
    }
    else{
        t_base = t_base + (nb * 58);
    }
    var c = t_base + 'px';
    document.getElementById('board').style.width = c;
}


//verifier si le mot propose par l'utilisateur est valide
function valide(mot){
    return true;
}


function darkMode() {
    var element = document.body;
    element.classList.toggle("dark-mode");
    if (element.classList.contains('dark-mode')){
        console.log("contain");
        document.cookie = "theme=dark";
    }
    else {
        console.log("dont contain");
        document.cookie = "theme=light";
    }
    document.activeElement.blur();
  }
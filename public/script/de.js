//ce fichier a pour but de faire la simulation d'un lancée d'un dé a 100 face

//de et la bouton de lancée, il represante le dé en lui meme.
const de = document.getElementById("de");
//result est la division dans le quel sera affiche la resultat du lancée
const resultat = document.getElementById("result")
//stat est la valeur de reference pour le resultat c'est cette variable qui sera en mesure de dire si le lance est reussi ou si il a échouer
const stat = document.getElementById("select-stat")
// la cA est un malus on va soustraire la stat a la ca et donnera une vision plus precise sur les chance de réussite
const cA = document.getElementById("ca")
let str = ""
let valMalus;
let lance;

//cette fonction simmulle le lancée de dé
//un chiffre compris entre 1 et 100 sera pris au hasard puis la fonction va regarder si le lence sera dans la range indiquer
de.addEventListener('click', () => {
    let str = "";
    let lance = Math.floor(Math.random() * 100 + 1)
    let valMalus = stat.value - cA.value
    let symbol = "<"
    if (lance <= 5) {
        succes = "<p>succée  critique !</p>";
    }
    else if (lance < valMalus) {
        succes = "<p>succée !</p>";

    }
    else if (lance > valMalus && lance <= stat.value) {
        symbol = ">";
        succes = "<p>presque reussite !</p>";

    }
    else if (lance >= 96) {
        symbol = ">";
        succes = "<p>echec  critique !</p>";
    }
    else {
        symbol = ">";
        succes = "<p>echec !</p>"
    }
    str = "<p> " + lance + symbol + valMalus + "</p>" + succes
    resultat.innerHTML = str
    resultat.style.background = "rgba(0, 102, 0, 0.5)"
    setTimeout(() =>{
        resultat.style.background = "rgba(238, 212, 177, 0.50)"
    }, 1200)
})

dices = document.querySelectorAll(".dice");
dices.forEach(dice => {
    dice.addEventListener("click", () =>{
        let typeDice = getTypeDice(dice.id);
        result = Math.floor(Math.random() * typeDice + 1); 
        resultat.innerText = result;
        resultat.style.background = "rgba(0, 102, 0, 0.5)"
        setTimeout(() =>{
            resultat.style.background = "rgba(238, 212, 177, 0.50)"
        }, 1200)
    })
});

function getTypeDice(elementId){
    let typeDice = 0
    switch (elementId) {
        case "dice-four":
            typeDice = 4;
            break;
        case "dice-six":
            typeDice = 6;
            break;
        case "dice-height":
            typeDice = 8;
            break;
        case "dice-ten":
            typeDice = 10;
            break;
        case "dice-twelve":
            typeDice = 12;
            break;
        case "dice-twenty":
            typeDice = 20;
            break;
        case "dice-hundred":
            typeDice = 100;
            break;
        default:
            typeDice = 100;
            break;
    }
    return typeDice
}
//ce fichier a pour but de faire la simulation d'un lancée d'un dé a 100 face

//de et la bouton de lancée, il represante le dé en lui meme.
const de = document.getElementById("de");
//result est la division dans le quel sera affiche la resultat du lancée
const resultat = document.getElementById("result")
//stat est la valeur de reference pour le resultat c'est cette variable qui sera en mesure de dire si le lance est reussi ou si il a échouer
const stat = document.getElementById("stat")
// la cA est un malus on va soustraire la stat a la ca et donnera une vision plus precise sur les chance de réussite
const cA = document.getElementById("ca")
let str = ""
let valMalus;
let lance;

//cette fonction simmulle le lancée de dé
//un chiffre compris entre 1 et 100 sera pris au hasard puis la fonction va regarder si le lence sera dans la range indiquer
de.addEventListener('click', () => {
    str = "";
    lance = Math.floor(Math.random() * 100 + 1)
    valMalus = stat.value - cA.value
    str += "<p> " + lance + "<" + valMalus + "(" + stat.value + " - " + cA.value + ") </p>"
    if (lance <= 5) {
        str += "succée  critique !"
    }
    else if (lance < valMalus) {
        str += "succée !"


    }
    else if (lance > valMalus && lance <= stat.value) {
        str += "presque reussite !"

    }
    else if (lance >= 95) {
        str += "echec  critique !"
    }
    else {
        str += "echec !"
    }
    resultat.innerHTML = str
})
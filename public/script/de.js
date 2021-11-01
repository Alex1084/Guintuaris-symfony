const de = document.getElementById("de");
const resultat = document.getElementById("result")
const stat = document.getElementById("stat")
const cA = document.getElementById("ca")
let str = ""
let valMalus;
let lance;
de.addEventListener('click', () => {
    str = "";
    lance = Math.floor(Math.random() * 100 +1)
    valMalus =  stat.value - cA.value
    str += "<p> "+ lance +"<"+ valMalus +"("+ stat.value +" - "+ cA.value +") </p>"
    if (lance <= 5){
        str += "Succèe critique !"
    }
    else if(lance < valMalus){
        str += "Succèe !"

        
    }
    else if(lance > valMalus && lance <= stat.value){
        str += "Presque réussite !"

    }
    else if (lance >= 95){
        str += "Echec critique !"
    }
    else {
        str += "Echec !"
    }
    resultat.innerHTML = str
})
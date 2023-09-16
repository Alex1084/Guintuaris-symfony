//ce fichier a pour but de faire la simulation d'un lancée d'un dé a 100 face

let resultat = document.getElementById("result")


dices = document.querySelectorAll(".dice");
dices.forEach(dice => {
    dice.addEventListener("click", () =>{
        let faceNumber = dice.dataset.faceNumber;
        result = Math.floor(Math.random() * faceNumber + 1); 
        resultat.innerText = result;
        resultat.style.background = "rgba(0, 102, 0, 0.5)"
        setTimeout(() =>{
            resultat.style.background = "rgba(238, 212, 177, 0.50)"
        }, 1200)
    })
});
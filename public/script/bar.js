const divStats = document.querySelectorAll(".statut");

//sur les trois division status de la fiche de personnage cette fonction permet avec des input de changer se statut
//les division numerique et bar sont des division en read only et les division ajout et soustrait son les opperendre qui vont interagir
//avec les divisions numerique 
divStats.forEach((div) => {
    console.log(div);
    const valNumerique = div.querySelector(".numerique")
    const valeBar = div.querySelector(".bar");
    const degat = div.querySelector(".soustrait");
    const soin = div.querySelector(".ajout");


    degat.addEventListener('keypress', (e) => statut(e, "-", valNumerique, degat, valeBar))

    soin.addEventListener('keypress', (e) => statut(e, "+", valNumerique, soin, valeBar))
})
//cette fonction permet de faire l'opperation entre la valeur numerique et l'ajout ou la soustraction
//la fonction agit que quand l'utilisateur est appui sur entrée
//la fonction prend en parametre un opperateur qui seras un "+" ou un "-"
//la valNum sera la valeur a gauche de l'opperation et seras la valeur qui sera changer
//l'opperrande seras la valeur a droite de l'opperation (c'est la valeur à ajouter ou à soustraire)
// et la valBare s'est la bar qui est afficher sur la fiche
function statut(event, opperateur, valNum, operande, valeBare) {
    if (event.key === 'Enter') {
        event.preventDefault();
        valNum.value = eval(valNum.value + opperateur + operande.value);
        operande.value = "";
        if (valeBare != null) {
            valeBare.value = valNum.value;
        }
    }
}
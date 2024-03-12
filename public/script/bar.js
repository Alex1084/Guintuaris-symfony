const divStatus = document.querySelectorAll(".statut");

//sur les trois division status de la fiche de personnage cette fonction permet avec des input de changer se statut
//les division numerique et bar sont des division en read only et les division ajout et soustrait son les opperendre qui vont interagir
//avec les divisions numerique 
divStatus.forEach((div) => {
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
    keys = ["ArrowLeft", "ArrowRight", "Backspace", "End", "Home", "-", "Enter"]
    re = new RegExp("[0-9]")
    if (!re.test(event.key)) {
        if (!keys.includes(event.key)) {
            event.preventDefault();
        }
        else if (event.key === 'Enter') {
            event.preventDefault();
            if (isNaN(operande.value) == true || operande.value <= 0) {
                Swal.fire({
                    position: 'top-end',
                    title: "Veuillez Entrée un nombre superieur a 0",
                    showConfirmButton: false,
                    timer: 1500,
                    background : 'url(../../img/toast.png)',
                    customClass : {
                        popup : "toast-custom",
                        title : "swal-cancel"
                    },  
                    toast : true
                })
                return
            }
            valNum.value = eval(valNum.value + opperateur + operande.value);
            operande.value = "";
            if (valeBare != null) {
                valeBare.value = valNum.value;
            }
            ajax();
        }
    }
    
}
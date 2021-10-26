/* function changeValue(idinput, idRange){
    const input = document.getElementById(idinput);
    console.log(input);
    const range = document.getElementById(idRange);
    console.log(range);
    input.oninput = (() => {
        document.getElementById('pc-range').value = pcInput.value
    })

    range.oninput = (() =>{
        document.getElementById('pc').value = pcRange.value
    })
} */



const divStats = document.querySelectorAll(".statut");
divStats.forEach((div) => {
    console.log(div);
    const valNumerique = div.querySelector(".numerique")
    const valeBar = div.querySelector(".bar");
    const degat = div.querySelector(".soustrait");
    const soin = div.querySelector(".ajout");


    degat.addEventListener('keypress', (e) => statut(e, "-", valNumerique, degat, valeBar))

    soin.addEventListener('keypress', (e) => statut(e, "+", valNumerique, soin, valeBar))
})

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
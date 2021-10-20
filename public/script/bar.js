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



const divStats = document.querySelectorAll(".stat");
divStats.forEach((div) =>{
    console.log(div);
    const valNumerique = div.querySelector(".numerique")
    const valeBar = div.querySelector(".bar");
    const degat = div.querySelector(".soustrait");
    const soin = div.querySelector(".ajout");

    
    degat.addEventListener('keypress', (e) => {
        if (e.key === 'Enter'){
            e.preventDefault();
            valNumerique.value = eval(valNumerique.value - degat.value);
            degat.value = "";
            if( valeBar != null){
                valeBar.value = valNumerique.value;
            }
        }
    })
    
    soin.addEventListener('keypress', (e) => {
        if (e.key === 'Enter'){
            e.preventDefault();
            valNumerique.value = eval(valNumerique.value + "+" + soin.value)
            soin.value = "";
            if( valeBar != null){
                valeBar.value = valNumerique.value;
            }
        }
        
    })
})

$("form").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
      return false;
    }
  });
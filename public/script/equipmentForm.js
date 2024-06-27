let pieces = document.querySelectorAll(".div-form")

for (let pieceForm of pieces) {
    let pieceSelect = pieceForm.querySelector("select")

    updateDisplay()

    pieceSelect.addEventListener("change", updateDisplay)

    function updateDisplay()
    {
        let otherInfo = pieceForm.querySelector(".other-info")
        if (pieceSelect[pieceSelect.selectedIndex].text == "Enlever" || 
        pieceSelect[pieceSelect.selectedIndex].text == "Vide")
            otherInfo.style.display = 'none'
        else
            otherInfo.style.display = 'block'

        infosInputs = otherInfo.querySelectorAll('input')
        for (let input of infosInputs) {
            input.value = ""            
        }
        otherInfo.querySelector("select").selectedIndex = 0
    }

}
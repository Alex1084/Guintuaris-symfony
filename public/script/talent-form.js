const newTalentForm = document.getElementById("new-talent-form-selector");
const talentSelector = document.getElementById("talents-selector")
const form = document.getElementById("talent-updated")
const tbody = document.getElementById("paginate-table-body")
let data

init()
function init() {
    data = JSON.parse(tbody.dataset.talent)
    if ( Array.isArray(data) || data === null)
    {
        data = {}
    }
    for (let talent in data) {
        addTalentInTable(
            talent, 
            data[talent].name,
            data[talent].isVisible,
            data[talent].level,
            data[talent].otherBonus)
    }
}

function addTalentInTable(id, name, isVisible = false, level = 0, otherBonus = 0) {
    let html = `
        <tr id="${id}">
            <td>${name}</td>
            <td>
                <select name="${id}[level]" id="${id}[level]">
                <option ${level == 0 ? "selected":""} value="0">Debutant</option>
                <option ${level == 1 ? "selected":""} value="1">Apprenti</option>
                <option ${level == 2 ? "selected":""} value="2">Avancé</option>
                <option ${level == 3 ? "selected":""} value="3">Maitre</option>
                </select>
            </td>
            <td>
                <input type="number" id="${id}[other-bonus]" name="${id}[ohther-bonus]" value="${otherBonus}">
            </td>
            <td>
                <input type="checkbox" id="${id}[visible]" name="${id}[visible]" ${isVisible == true? 'checked="checked"':""}>
                <label class="checkbox-label" for="${id}[visible]">
                    <span class="checkbox-button"></span>
                </label>
            </td>
            <td>
                <button id="${id}[delete]">delete !</button>
            </td>
        </tr>
    `
    tbody.insertAdjacentHTML( 'beforeend', html );

    initTalent(id)
}

newTalentForm.addEventListener("submit", (e) => {
    e.preventDefault();
    let talent = talentSelector.value
    let talentOption = talentSelector[talentSelector.selectedIndex]
    talentOption.remove();
    addTalentInTable(talent, talentOption.text, true)
})

function initTalent(id) {

    if (data[id] == undefined) {  
        data[id] = {
            level : 0,
            otherBonus : 0,
            isVisible : true
        }
    }

    document.getElementById(id+"[level]").addEventListener("change", e => {
        data[id]["level"] = e.target.value
    })
    document.getElementById(id+"[other-bonus]").addEventListener("change", e => {

        if (parseInt(e.target.value)) {
           data[id]["otherBonus"] = e.target.value
        } 
        else {
           data[id]["otherBonus"] = 0
        }

    })
    document.getElementById(id+"[visible]").addEventListener("change", e => {
        data[id]["isVisible"] = e.target.checked
    })
    document.getElementById(id+"[delete]").addEventListener("click", e => {
        e.preventDefault();

        let html = `<option value="${id}">${data[id].name}</option>`
        talentSelector.insertAdjacentHTML( 'beforeend', html )
        
        delete(data[id]);
        document.getElementById(id).remove();
    })
}

form.addEventListener("submit", (e) => {
    e.preventDefault()

    let trueForm = document.createElement('form')
    trueForm.method = 'post'
    let inputValues = document.createElement('input', {})
    inputValues.value = JSON.stringify(data);
    inputValues.name = 'talents'
    inputValues.type = 'hidden'
    trueForm.appendChild(inputValues)

    document.querySelector('.container').appendChild(trueForm)
    trueForm.submit();
})
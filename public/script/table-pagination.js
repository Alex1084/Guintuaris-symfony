let table = document.getElementById("talent-table-body")
let paginationElement = document.getElementById("pagination")

let data = [
    {
        name : "Lutte",
        level : "Avancé",
        experience : "0",
        otherBonus : "5",
        // stat : "",
    },
    {
        name : "Armes à une mains",
        level : "Apprenti",
        experience : "100",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Vol à la tir",
        level : "Maître",
        experience : "0",
        otherBonus : "10",
        // stat : "",
    },
    {
        name : "Represantation",
        level : "Avancé",
        experience : "0",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Medecine",
        level : "Apprenti",
        experience : "0",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Lutte",
        level : "Avancé",
        experience : "0",
        otherBonus : "5",
        // stat : "",
    },
    {
        name : "Armes à une mains",
        level : "Apprenti",
        experience : "100",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Vol à la tir",
        level : "Maître",
        experience : "0",
        otherBonus : "10",
        // stat : "",
    },
    {
        name : "Represantation",
        level : "Avancé",
        experience : "0",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Medecine",
        level : "Apprenti",
        experience : "0",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Lutte",
        level : "Avancé",
        experience : "0",
        otherBonus : "5",
        // stat : "",
    },
    {
        name : "Armes à une mains",
        level : "Apprenti",
        experience : "100",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Vol à la tir",
        level : "Maître",
        experience : "0",
        otherBonus : "10",
        // stat : "",
    },
    {
        name : "Represantation",
        level : "Avancé",
        experience : "0",
        otherBonus : "0",
        // stat : "",
    },
    {
        name : "Medecine",
        level : "Apprenti",
        experience : "0",
        otherBonus : "0",
        // stat : "",
    },
]


function init() {
    let pageNumber = Math.ceil(data.length/10)
    let currentPage = 1

    let pagination = '<button class="pagination-button" data-page="previous">&lt</button>'
    for (let i = 1; i <= pageNumber; i++) {
        pagination += '<button data-page="'+i+'" class="pagination-button">'+i+'</button>'
    }
    pagination += '<button class="pagination-button" data-page="next">&gt</button>'
    paginationElement.innerHTML = pagination
    changePage(currentPage)

    let buttons = document.querySelectorAll(".pagination-button")

    for (let button of buttons) {
        button.addEventListener('click', () => {
            let buttonData = button.dataset.page
            let page
            if (buttonData == "previous")
                page = currentPage - 1
            else if (buttonData == "next")
                page = currentPage + 1
            else
                page = buttonData

            if (page <= pageNumber && page >= 1) {
                console.log(page);
                changePage(page)
                currentPage = page
            }
        })
    }
}

function changePage(page) {
    let firstValue = 10*(page-1)
    let lastValue = 10*page
    table.innerHTML = ''
    for (let i = firstValue; i < lastValue; i++) {
        let row = document.createElement('tr')
        for (let key in data[i]) {
            let field = document.createElement("td")
            field.innerText = data[i][key]
            row.appendChild(field)
                
        }
        table.appendChild(row)
    }        
}

init()
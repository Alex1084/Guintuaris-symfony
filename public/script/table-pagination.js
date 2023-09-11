let tbody = document.getElementById("paginate-table-body")
let paginationElement = document.getElementById("pagination")
const statistics = { 
    1 : "constitution",
    2 : "strength",
    3 : "dexterity",
    4 : "intelligence",
    5 : "charisma",
    6 : "faith",
};
const LEVEL_NAMES = {
    0 : "Débutant",
    1 : "Aprenti",
    2 : "Avancé",
    3 : "Maître",
}

function init() {
    data = loadData()
    let pageNumber = Math.ceil(data.length/10)
    let currentPage = 1

    if (pageNumber >= 2) {
        let pagination = '<button class="pagination-button" data-page="previous">&lt</button>'
        for (let i = 1; i <= pageNumber; i++) {
            pagination += '<button data-page="'+i+'" class="pagination-button">'+i+'</button>'
        }
        pagination += '<button class="pagination-button" data-page="next">&gt</button>'
        paginationElement.innerHTML = pagination
    }
    changePage(data, currentPage)

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
                changePage(data,page)
                currentPage = page
            }
        })
    }
}

function changePage(data,page) {
    let firstValue = 10*(page-1)
    let lastValue = 10*page
    tbody.innerHTML = ''
    for (let i = firstValue; i < lastValue; i++) {
        let html = `
        <tr>
            <td>${data[i].name}</td>
            <td>${LEVEL_NAMES[data[i].level]} (${data[i].level * 5 })</td>
            <td>${data[i].otherBonus}</td>
            <td>${data[i].total}</td>
        </tr>`
        tbody.insertAdjacentHTML( 'beforeend', html )
    }        
}

function loadData() {
    let talents = JSON.parse(tbody.dataset.talents)
    let data = []
    for (let key in talents) {
        let stisticName = statistics[talents[key].statistic]
        let stasticElement = document.querySelector(".statistique-valeur[data-"+stisticName+"]");

        talents[key]['total'] = +stasticElement.dataset[stisticName] + talents[key].level*5 + +talents[key].otherBonus
        if (talents[key].isVisible == true) {
            data.push(talents[key])
        }
    }
    return data
}

init()
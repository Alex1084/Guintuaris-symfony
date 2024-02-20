const STATISTICS = { 
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

class Talents 
{
    constructor()
    {
        this.displayTableBody = document.getElementById("paginate-table-body")
        this.equipedTalents = JSON.parse(this.displayTableBody.dataset.talents)
        this.displayableData = []

        this.talentSelect = document.getElementById("select-talent");
        this.talentsData = JSON.parse(this.talentSelect.dataset.talents);
        this.statisticSelect = document.getElementById("select-stat")
        this.statisticsData = JSON.parse(this.statisticSelect.dataset.statistic);

        this.rngButton = document.getElementById("talent-dice")
        this.modifierSelect = document.getElementById("modifier")
        this.init()
    }

    init () {
        this.initEquipedTalent()
        this.pageNumber = Math.ceil(this.displayableData.length/10)
        this.currentPage = 1
        this.initPagination()
        this.changePage()


        this.initAllTalent()
        this.initRGNSelects()
        this.rngListenner()
    }

    changePage() {
        let firstValue = 10*(this.currentPage-1)
        let lastValue = 10*this.currentPage
        if (lastValue >= this.displayableData.length) {
            lastValue = this.displayableData.length
        }
        this.displayTableBody.innerHTML = ''
        for (let i = firstValue; i < lastValue; i++) {
            let html = `
            <tr id="talent-${this.displayableData[i].id}">
                <td>${this.displayableData[i].name}</td>
                <td>${LEVEL_NAMES[this.displayableData[i].level]} (${this.displayableData[i].level * 5 })</td>
                <td>${this.displayableData[i].otherBonus}</td>
                <td>${this.displayableData[i].total}</td>
            </tr>`
            this.displayTableBody.insertAdjacentHTML( 'beforeend', html )
        }        
    }

    initPagination() {
        let paginationElement = document.getElementById("pagination");
        if (this.pageNumber >= 2) {
            let pagination = '<button class="pagination-button" data-page="previous">&lt</button>'
            for (let i = 1; i <= this.pageNumber; i++) {
                pagination += '<button data-page="'+i+'" class="pagination-button">'+i+'</button>'
            }
            pagination += '<button class="pagination-button" data-page="next">&gt</button>'
            paginationElement.innerHTML = pagination
        }
    
        let buttons = document.querySelectorAll(".pagination-button")
    
        for (let button of buttons) {
            button.addEventListener('click', () => {
                let buttonData = button.dataset.page
                let page
                if (buttonData == "previous")
                    page = this.currentPage - 1
                else if (buttonData == "next")
                    page = this.currentPage + 1
                else
                    page = buttonData
    
                if (page <= this.pageNumber && page >= 1) {
                    this.currentPage = page
                    this.changePage()
                }
            })
        }
    }

    initEquipedTalent() {
        for (let key in this.equipedTalents) {
            let stisticName = STATISTICS[this.equipedTalents[key].statistic]
            let stasticElement = document.querySelector(".statistique-valeur[data-"+stisticName+"]");
    
            this.equipedTalents[key]['total'] = 
                      +stasticElement.dataset[stisticName] 
                    + +this.equipedTalents[key].level*5 
                    + +this.equipedTalents[key].otherBonus
            if (this.equipedTalents[key].isVisible == true) {
                this.displayableData.push(this.equipedTalents[key])
            }
        }
    }

    initRGNSelects() {


        let statisticsOptions = ''
        for (let key in this.statisticsData) {
            statisticsOptions += `<option value="${this.statisticsData[key].id}">${this.statisticsData[key].name}</option>`
        }
        this.statisticSelect.insertAdjacentHTML( 'beforeend', statisticsOptions )
        this.changeTalentOption(this.talentsData);
        this.statisticSelect.addEventListener('change', (e) =>{
            let data = []
            if (e.target.value == 0) {
                this.changeTalentOption(this.talentsData);
                return
            }
            
            for (let key in this.talentsData) {
                if (this.talentsData[key].statisticId == e.target.value) {
                    data.push(this.talentsData[key]);
                }
            }
            this.changeTalentOption(data)
    
        })
    }

    initAllTalent() {
        let allData = {}
        for (let key in this.talentsData) {
            let talent = this.talentsData[key]

            let data = {
                htmlOption : `<option value="${talent.id}">${talent.name}</option>`,
                statisticId : talent.statistic_id,
            }

            if (talent.id in this.equipedTalents) {
                data.total = this.equipedTalents[talent.id].total
            }
            else {
                let statisticName = STATISTICS[talent.statistic_id]
                let stasticElement = document.querySelector(".statistique-valeur[data-"+statisticName+"]");
                data.total = stasticElement.dataset[statisticName]
            }
            allData[talent.id] = data;
        }
        for (let key in this.statisticsData) {
            let statistic = this.statisticsData[key];
            let statisticName = STATISTICS[statistic.id];
            let stasticElement = document.querySelector(".statistique-valeur[data-"+statisticName+"]");
            let id = Object.keys(allData).length + 1;
            let data = {
                htmlOption :`<option value="${id}">${statistic.name} pur</option>`,
                total : stasticElement.dataset[statisticName],
                statisticId : statistic.id,
            }
            allData[id] = data;
        }
        this.talentsData = allData
    }

    changeTalentOption(data) {
        let talentsOptions = ''
        for (let key in data) {
            talentsOptions += data[key].htmlOption
        }
        this.talentSelect.innerHTML = talentsOptions;
    }

    rngListenner()
    {
        this.rngButton.addEventListener("click", e => {
           let talentId = this.talentSelect.value;
           let talentData = this.talentsData[talentId];
           let total = talentData.total;
           let modifier = this.modifierSelect.value;
           let totalWithModifier = +total + +modifier
           let randomNumber = Math.floor(Math.random() * 100 + 1);
           let message = ''
           if (randomNumber <= 5) {
                message = 'succée critique'
                resultat.style.background = "rgba(0,192,0,0.5)"
            }
           else if (randomNumber >= 96) {
                message = 'echec critique'
                resultat.style.background = "rgba(0,0,0,0.5)"
            }
           else if (randomNumber <= totalWithModifier) {
                message = 'succée'
                resultat.style.background = "rgba(0,102,0,0.5)"
            }
        //    else if (randomNumber > totalWithModifier && randomNumber <= total ) {
        //         message = 'presque reusite'
        //         resultat.style.background = "rgba(170,90,0,0.5)"
        //     }
           else if (randomNumber >= total) {
                message = 'echec'
                resultat.style.background = "rgba(170,0,0,0.5)"
            }
            message = `<p>${message}</p> <p>${randomNumber}/${totalWithModifier} </p>`
           resultat.innerHTML = message;

           setTimeout(() =>{
               resultat.style.background = "rgba(238, 212, 177, 0.50)"
           }, 1200)
        })
    }
}

let talents = new Talents();
class TablePagination
{
    constructor(tableId)
    {
        this.table = document.getElementById(tableId);

        this.tbody = this.table.querySelector("tbody");
        this.data = [...tbody.children];
        this.rowsPerPage = 10;
        this.pageNumber = Math.ceil(this.data.length/this.rowsPerPage);

        this.currentPage = 1;
        this.initPagination();
        this.changePage();
    }

    changePage() {
        let firstValue = this.rowsPerPage*(this.currentPage-1)
        let lastValue = this.rowsPerPage*this.currentPage
        if (lastValue >= this.data.length) {
            lastValue = this.data.length
        }
        this.tbody.innerHTML = ''
        for (let i = firstValue; i < lastValue; i++) {
            this.tbody.insertAdjacentHTML( 'beforeend', this.data[i].innerHTML )
        }        
    }

    initPagination() {
        if (this.pageNumber < 2)
            return

        let paginationElement = this.table.parentElement.querySelector("div.pagination")

        let pagination = '<button class="pagination-button" data-page="previous">&lt</button>'
        for (let i = 1; i <= this.pageNumber; i++) {
            pagination += '<button data-page="'+i+'" class="pagination-button">'+i+'</button>'
        }
        pagination += '<button class="pagination-button" data-page="next">&gt</button>'
        paginationElement.innerHTML = pagination

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
}

// document.querySelectorAll('.tableau')
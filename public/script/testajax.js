/* const form = document.getElementById("add");


form.addEventListener('submit', (e) => {
    e.preventDefault();
    const url = this.attr('action');

    axios.get(url).then(function (response) {
        console.log(response);
    })
}) */

// ~~~~~~~~~~~~~~~~ test avec Nouvel techno ~~~~~~~~~~~~~~~~~~~~~~~~
/* window.onload = () => {
    let bete = document.getElementById('board_bete');
    bete.addEventListener('change', function () {
        let form = this.closest("form");
        let data = this.name + "=" + this.value;

        fetch(form.action, {
            method: form.getAttribute("method"),
            body: data,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset: UTF-8"
            }
        })
            .then(response => response.text)
            .then(html => {
                let content = document.createElement("html");

                content.innerHTML = html;
                let newSelect = content.getElementById('board_nom');
                document.querySelector('.contaioner').innerHTML = newSelect
            })
            .catch(error => {
                console.log(error);
            })
    })
} */

// ~~~~~~~~~~~~~~~~ test Lior chamla ~~~~~~~~~~~~~~~~~~~~~~~~
function onClickBtnLike(event) {
    event.preventDefault();
    const url = this.href;
    axios.get(url).then(function (response) {
        //console.log(response)
        monstre = response.data.bete;
        console.log(monstre)

        const container = document.querySelector(".container");
        container.innerHTML += insertFiche(monstre);
        //container.innerHTML += "<p>bonjour tous le mondes</p> <br>"
    });
}

document.querySelectorAll("a.js-like").forEach((link) => {
    link.addEventListener('click', onClickBtnLike);
})

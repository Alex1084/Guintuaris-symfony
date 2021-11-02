const select = document.querySelector("#form_bete")
const addFiche = document.querySelector("#add");
let containerRow = document.querySelectorAll(".container-fluid>.row")
let fiches = document.querySelectorAll(".fiche");
const container = document.querySelector(".container-fluid")
let last = containerRow[containerRow.length - 1];
let row = 0;

// cette fonction a pour but de barrer une fiche ou de la débarrer et de supprimer la fiche du DOM
// la constante mort est une image qui lorsqu'on clique dessus une barre (constante bar) rouge apparait et recouvre l'integraliter de la fiche (cette barre disparait lorsqu'un deuxime clique est effectuer)
//la constante quitter elle permetc de remove la fiche du DOM
function ficheControl(fiche) {
    const mort = fiche.querySelector('.mort');
    const barre = fiche.querySelector('.barre');
    const quitter = fiche.querySelector('.croix');

    const divsStatuts = fiche.querySelectorAll(".statut")
    divsStatuts.forEach(statutListener)
    mort.addEventListener('click', () => {
        if (barre.style.display === 'block') {
            barre.style.display = 'none';
            barre.style.zIndex = -1;
        }
        else {
            barre.style.display = 'block';
            barre.style.zIndex = 1;
        }
    })
    quitter.addEventListener('click', () => {
        fiche.remove();
        if (row > 1) {
            row--
        }
        else if (row === 0) {
            row = 4
        }
    })
}

//cette fonction a pour but de pouvoir changer le statut d'une fiche en utilisant la fonction statut contennu dans le fichier bar.js
function statutListener(div) {
    const valNumerique = div.querySelector(".numerique")
    const degat = div.querySelector(".soustrait");
    const soin = div.querySelector(".ajout");
    const valBar = null


    degat.addEventListener('keypress', (e) => statut(e, "-", valNumerique, degat, valBar))
    soin.addEventListener('keypress', (e) => statut(e, "+", valNumerique, soin, valBar))
}


// cette fonction créer une division nommé fiche en html qui represente une fiche
//cette division sera contenu dans une division row si la variable row est egale a 1
//cette fiche contiendra toute les information de l'objet monstres
function insertFiche(monstre) {
    let str = ''
    row++;
    if (row === 1) {
        containerRow = document.querySelectorAll(".container-fluid>.row");
        last = containerRow[containerRow.length - 1];
        str += '<div class="row">';
    }
    str += `  <div class="fiche col-md-3">
            <img src="img/barre_mort.png" alt="" class="barre">
            <h3>${monstre.nom}</h3> <img src="img/mort.png" alt="" class="icon mort"> <img src="img/croix.png" alt="" class="icon croix">
            <div class="row">
                <div class="col-md-4">
                    <p>Constitution</p>
                    <span class="stat">${monstre.constitution}</span>
                </div>
                <div class="col-md-4">
                    <p>Force</p>
                    <span class="stat">${monstre.laForce}</span>
                </div>
                <div class="col-md-4">
                    <p>Dexterité</p>
                    <span class="stat">${monstre.dexterite}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p>Intelligence</p>
                    <span class="stat">${monstre.intelligence}</span>
                </div>
                <div class="col-md-4">
                    <p>Charisme</p>
                    <span class="stat">${monstre.charisme}</span>
                </div>
                <div class="col-md-4">
                    <p>Foi</p>
                    <span class="stat">${monstre.foi}</span>
                </div>
            </div>

            <div class="statut">
                <label for="">PV</label><input type="integer" value="${monstre.pv}" class="numerique" readonly> <input type="integer" class="enabled ajout"> <input type="integer" class="enabled soustrait"> <br>
            </div>
            
            <div class="statut">
                <label for="">PM</label><input type="integer" value="${monstre.pm}" class="numerique" readonly> <input type="integer" class="enabled ajout"> <input type="integer" class="enabled soustrait"> <br>
            </div>
            
            <div class="statut">
                <label for="">PC</label><input type="integer" value="${monstre.pc}" class="numerique" readonly> <input type="integer" class="enabled ajout"> <input type="integer" class="enabled soustrait"> <br>
            </div>
        </div>`;

    if (row === 1) {

        str += '</div>';
    }
    if (row === 4) {
        row = 0;
    }
    return str;
}

// cette fonction a pour but d'inserer une nouvelle fiche dans le DOM
//avec un conteur (allant de 0 4 ) un if decide si on peut ajouter la fiche dans la dernire row creer
//sinon la fonction insert la fiche dans le container
//la fonction va chercher un objet qui est une requate dans le backend
//et le revoie au format json le json est ensuite traduit en objet et est envoyer la la fonction insertFiche
function onClickBtnLike(event) {
    containerRow = document.querySelectorAll(".container-fluid>.row");
    last = containerRow[containerRow.length - 1];
    event.preventDefault();
    const url = this.href;
    axios.get(url).then(function (response) {
        monstre = response.data;

        const container = document.querySelector(".container-fluid");
        if (row < 1) {
            container.innerHTML += insertFiche(monstre);
        }
        else if (row >= 1) {
            last.innerHTML += insertFiche(monstre);
        }
        fiches = document.querySelectorAll(".fiche");
        fiches.forEach(ficheControl)
    });
}

document.querySelectorAll("a.js-like").forEach((link) => {
    link.addEventListener('click', onClickBtnLike);
})
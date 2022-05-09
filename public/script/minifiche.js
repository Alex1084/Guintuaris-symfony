const select = document.querySelector("#form_bete")
const addFiche = document.querySelector("#add");
let fiches = document.querySelectorAll(".fiche");
const container = document.querySelector(".board")

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
        fiche.classList.add("fiche-remove")
        setTimeout(() => {
            fiche.remove();
        }, 2000);
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
    if (monstre.note == null) {
        monstre.note = ""
    }
    str += `  <div class="fiche ">
            <img src="../img/barre_mort.png" alt="" class="barre">
            <h3 class="title">${monstre.nom}</h3> <img src="../img/mort.png" alt="" class="icon mort"> <img src="../img/croix.png" alt="" class="icon croix">
            <div class="div-statistique">
                <div>
                    <p>Constitution</p>
                    <span class="stat">${monstre.constitution}</span>
                </div>
                <div>
                    <p>Force</p>
                    <span class="stat">${monstre.strength}</span>
                </div>
                <div>
                    <p>Dexterité</p>
                    <span class="stat">${monstre.dexterity}</span>
                </div>
                <div>
                    <p>Intelligence</p>
                    <span class="stat">${monstre.intelligence}</span>
                </div>
                <div>
                    <p>Charisme</p>
                    <span class="stat">${monstre.charisma}</span>
                </div>
                <div>
                    <p>Foi</p>
                    <span class="stat">${monstre.faith}</span>
                </div>
            </div>

            <div class="statut">
                <label for="">PV</label><input type="integer" value="${monstre.pv}" class="numerique" readonly> 
                <input type="integer" class="enabled ajout" placeholder="+"> 
                <input type="integer" class="enabled soustrait" placeholder="-">    
            </div>
            
            <div class="statut">
                <label for="">PM</label><input type="integer" value="${monstre.pm}" class="numerique" readonly> 
                <input type="integer" class="enabled ajout" placeholder="+"> 
                <input type="integer" class="enabled soustrait" placeholder="-">
            </div>
            
            <div class="statut">
                <label for="">PC</label><input type="integer" value="${monstre.pc}" class="numerique" readonly> 
                <input type="integer" class="enabled ajout" placeholder="+"> 
                <input type="integer" class="enabled soustrait" placeholder="-">
            </div>

            <textarea class="note">${monstre.note}</textarea>
        </div>`;
    return str;
}

// cette fonction a pour but d'inserer une nouvelle fiche dans le DOM
//avec un conteur (allant de 0 4 ) un if decide si on peut ajouter la fiche dans la dernire row creer
//sinon la fonction insert la fiche dans le container
//la fonction va chercher un objet qui est une requate dans le backend
//et le revoie au format json le json est ensuite traduit en objet et est envoyer la la fonction insertFiche
function onClickBtnLike(event) {
    event.preventDefault();
    const url = this.href;
    axios.get(url).then(function (response) {
        console.log(response.data);
        monstre = response.data;
        container.innerHTML += insertFiche(monstre);

        fiches = document.querySelectorAll(".fiche");
        fiches.forEach(ficheControl)

    });
}

document.querySelectorAll("a.js-like").forEach((link) => {
    link.addEventListener('click', onClickBtnLike);
})
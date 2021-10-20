    const select = document.querySelector("#form_bete")
    const addFiche = document.querySelector("#add");
    let containerRow = document.querySelectorAll(".container>.row")
    let fiches = document.querySelectorAll(".fiche");
    const container = document.querySelector(".container")
    let last = containerRow[containerRow.length -1];
    let object;
    let row = 0;
    //let fiche = ''
    select.addEventListener("input", (e) =>{
        object = e.target.value;
        console.log(object);
    })
    addFiche.addEventListener('submit', (e) => {
        containerRow = document.querySelectorAll(".container>.row");
        last = containerRow[containerRow.length -1];
        e.preventDefault();
        if(row < 1){
            container.innerHTML += insertFiche(object);    
        }
        else if(row >= 1){
            last.innerHTML += insertFiche(object);
        }
            fiches = document.querySelectorAll(".fiche");
            console.log(fiches);
            fiches.forEach((fiche) => {
                const mort = fiche.querySelector('.mort');
                const barre = fiche.querySelector('.barre');
                const quitter = fiche.querySelector('.croix');
                mort.addEventListener('click', () =>{
                    if(barre.style.display === 'block'){
                        barre.style.display = 'none';
                        barre.style.zIndex = -1;
                    }
                    else{
                        barre.style.display = 'block';
                        barre.style.zIndex = 1;
                    }
                })
                quitter.addEventListener('click', () => {
                    fiche.remove();
                    if(row > 1){
                        row--
                    }
                })
            })
    })

    function insertFiche(monstre){
        let str = ''
        row++;
        if(row === 1){
            containerRow = document.querySelectorAll(".container>.row");
            last = containerRow[containerRow.length -1];
            str += '<div class="row">';
        }
        str += `  <div class="fiche col-md-3">
            <img src="img/barre_mort.png" alt="" class="barre">
            <h3>${ monstre }</h3> <img src="img/mort.png" alt="" class="icon mort"> <img src="img/croix.png" alt="" class="icon croix">
            <div class="row">
                <div class="col-md-4">
                    <p>Constitution</p>
                    <span class="stat">30</span>
                </div>
                <div class="col-md-4">
                    <p>Force</p>
                    <span class="stat">50</span>
                </div>
                <div class="col-md-4">
                    <p>Dexterité</p>
                    <span class="stat">20</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p>Constitution</p>
                    <span class="stat">30</span>
                </div>
                <div class="col-md-4">
                    <p>Force</p>
                    <span class="stat">50</span>
                </div>
                <div class="col-md-4">
                    <p>Dexterité</p>
                    <span class="stat">20</span>
                </div>
            </div>

            <div class="statut">

                <label for="">PV</label><input type="integer" value="50" class="numerique" readonly> <input type="integer" class="enabled ajout"> <input type="integer" class="enabled soustrait"> <br>
                <label for="">PM</label><input type="integer" value="15" class="numerique" readonly> <input type="integer" class="enabled ajout"> <input type="integer" class="enabled soustrait"> <br>
                <label for="">PC</label><input type="integer" value="12" class="numerique" readonly> <input type="integer" class="enabled ajout"> <input type="integer" class="enabled soustrait"> <br>
            </div>
        </div>`;

        if(row === 1){
        
            str += '</div>';
        }
        if(row === 4){
            row = 0;
        }
        return str;
    }
const board = document.querySelector(".tableau");
let titleAlert = "";
let message = "";

if (board !== null) {
    const boardId = board.id;
    console.log(board);
    console.log(boardId);       
    switch (boardId) {
        case "skill":
            titleAlert = "Êtes-vous sûr de vouloir supprimer cette compétence ?";
            message = "<p>Si vous confirmez, cette compétence sera définitivement supprimée, aucune restauration ne sera possible.</p>";
            break;
        case "bestiary" : 
            titleAlert = "Êtes-vous sûr de vouloir supprimer cet élément du bestiaire ?";
            message = "<p>Si vous confirmez, cet élément du bestiaire sera définitivement supprimé, aucune restauration ne sera possible.</p>";
            break;
        case "weapon" :
            titleAlert = "Êtes-vous sûr de vouloir supprimer cette arme ?";
            message = "<p>Si vous confirmez, cette arme sera définitivement supprimée, aucune restauration ne sera possible.</p>";
            break;
        case "team" :
            titleAlert = "Êtes-vous sûr de vouloir supprimer cette équipe ?";
            message = "<p>Si vous confirmez, cette équipe sera définitivement supprimée, aucune restauration ne sera possible.</p><p>Les personnages ne seront pas supprimés, mais les joueurs n'auront plus accès aux fiches de leurs équipiers.</p>";
            break;
        default:
            titleAlert = "Êtes-vous sûr de vouloir supprimer cette donnée ?";
            message = "<p>Si vous confirmez, cette donnée sera définitivement supprimée, aucune restauration ne sera possible.</p>";
            break;
    }
}

document.querySelectorAll(".ajax-delete-link").forEach(link =>{
    
    link.addEventListener('click', (e) =>{
        e.preventDefault();
        row = link.parentElement.parentElement;
        dataId = row.querySelector(".data-id").textContent
        dataName = row.querySelector(".data-name").textContent
        let contentAlert = message + "<p>Id : "+ dataId +"</p><p> nom : "+dataName +"</p>"
        Swal.fire({
            title:titleAlert,
            html: contentAlert,
            showCancelButton: true,
            buttonsStyling : false,
            confirmButtonText: 'Oui, supprimer!', 
            cancelButtonText : 'Annuler',
            background : 'url(../../../img/scroll.png)',
            width : 479,
            heightAuto : false,
            padding : "2.5%",
            customClass : {
                popup : "swal-height",
                confirmButton : "swal-button swal-comfirm",
                cancelButton : "swal-button swal-cancel"
            }
        }).then((result) => {
            if(result.isConfirmed){
                sendDelete(link);
            }
          })
    })
})

function sendDelete(linkElement) {

    fetch(linkElement.href)
    .then(response => response.json())
    .then(data => {
        linkElement.parentElement.parentElement.remove();
    })
    .catch(error => {
        error => console.error(error.response.data)
    });
}

const showForm = document.getElementById("show-form");
const form = document.querySelector("form.hidden");
if (showForm != null) {   
    showForm.addEventListener("click", (e) => {
        e.preventDefault();
        if (form.classList.contains("hidden")) {
            form.classList.replace("hidden", "show");
            showForm.innerText = "Masquer le formulaire";
        } else {
            form.classList.replace("show", "hidden");
            showForm.innerText = "Ajouter un membre";
        }
    })
}


const updateLinks = document.querySelectorAll(".update-link")
updateLinks.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        let updateForm = document.getElementById("update-form");
        if(updateForm != null) {
            updateForm.parentElement.innerHTML = ` <a href="${link.href}" class="update-link">modifier</a>`;
        }
        link.parentElement.innerHTML = `<form action="${link.href}" id="update-form" method="post">
                            <input type="text" name="value" id="value">
                            <button class="">Modifier !</button>
                          </form>`
    })
})

const deleteAccount = document.getElementById("delete-account");

if (deleteAccount !== null) {
    
    deleteAccount.addEventListener('click', e => {
        e.preventDefault();
        Swal.fire({
            title: 'Etes vous sure de vouloir supprimer votre compte ?',
            text: "en cas de suppression tout les personnage crée sur ce coompte seron supprimmer",    
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!', 
            background : 'url(../img/scroll.png)',
            width : 479,
            heightAuto : false,
            customClass: 'swal-height',
            padding : "2.5%"
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = deleteAccount.href;
            }
          })

    })
}
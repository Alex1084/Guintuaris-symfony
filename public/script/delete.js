const board = document.querySelector(".tableau");
let titleAlert = "";
let contentAlert = "";

if (board !== null) {
    const boardId = board.id;
    console.log(board);
    console.log(boardId);       
    switch (boardId) {
        case "skill":
            titleAlert = "Etes vous sure de vouloir supprimer cette competance ?";
            contentAlert = "";
            break;
        case "bestiary" : 
            titleAlert = "Etes vous sure de vouloir supprimer cet element du bestiaire ?";
            contentAlert = "";
            break;
        case "weapon" :
            titleAlert = "Etes vous sure de vouloir supprimer cette arme ?";
            contentAlert = "";
            break;
        default:
            titleAlert = "test";
            contentAlert = "";
            break;
    }
}

document.querySelectorAll(".ajax-delete-link").forEach(link =>{
    
    link.addEventListener('click', (e) =>{
        e.preventDefault(); 
        Swal.fire({
            title:titleAlert,
            text: contentAlert,
            showCancelButton: true,
            // confirmButtonColor: '#3085d6',
            // cancelButtonColor: '#d33',
            buttonsStyling : false,
            confirmButtonText: 'Yes, delete it!', 
            background : 'url(../img/scroll-2.png)',
            width : 479,
            heightAuto : false,
            padding : "2.5%",
            customClass : {
                popup : "swal-height",
                confirmButton : "swal-button",
                cancelButton : "swal-button"
            }
        }).then((result) => {
            if(result.isConfirmed){
                axiosLink(link);
            }
          })
    })
})

function axiosLink(linkElement) {

    axios.get(linkElement.href).then(response =>{
        linkElement.parentElement.parentElement.remove();
    }).catch(error => console.error(error.response.data));
    
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
            background : 'url(../img/scroll-2.png)',
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
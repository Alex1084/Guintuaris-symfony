document.querySelectorAll(".ajax-delete-link").forEach(link =>{
    
    link.addEventListener('click', (e) =>{
        e.preventDefault();
        if (link.classList.contains("alert")) {   
            if (confirm("Etes vous sur de vouloir supprimmer ces donné")) {
                axiosLink(link);
            }
        }
        else{
            axiosLink(link);
        }
        
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
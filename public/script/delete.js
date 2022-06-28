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
        console.log(response);
        linkElement.parentElement.remove();
    }).catch(error => console.error(error.response.data));
    
}

const showForm = document.getElementById("show-form");
const form = document.querySelector("form.hidden");
console.log(showForm);

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
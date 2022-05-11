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
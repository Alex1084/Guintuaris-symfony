//ce fichier a pour but d'afficher ou de masque un texte contenu dans un division lorsque on appui sur le bouton pour l'afficher

const divs = document.querySelectorAll(".dropdown");
document.getElementById
divs.forEach((div) => {

    //button est le bouton qui sert a afficher le contenu
    const button = div.querySelector(".dropbtn");
    //dropdown est la division qui contient le contenu (c'est lui qui est afficher ou masquer)
    const dropdown = div.querySelector('.dropdown-content');
    const logo = div.querySelector('.drop-logo')
    button.addEventListener('click', () => {
        if (dropdown.classList.contains("hidden")) {
            dropdown.classList.replace("hidden", "show");
            logo.style.transform = "rotate(90deg)";
        }
        else {
            dropdown.classList.replace("show", "hidden");
            logo.style.transform = "rotate(0deg)";
        }
    })
})
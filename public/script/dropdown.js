//ce fichier a pour but d'afficher ou de masque un texte contenu dans un division lorsque on appui sur le bouton pour l'afficher

const divs = document.querySelectorAll(".dropdown");
divs.forEach((div) => {

    //button est le bouton qui sert a afficher le contenu
    const button = div.querySelector(".dropbtn");
    //dropdown est la division qui contient le contenu (c'est lui qui est afficher ou masquer)
    const dropdown = div.querySelector('.dropdown-content');
    const logo = div.querySelector('.drop-logo')
    button.addEventListener('click', () => {
        if (dropdown.style.display != "block") {
            dropdown.style.display = "block"
            logo.style.transform = "rotate(90deg)";
        }
        else {
            div.style.display = "inline-block";
            dropdown.style.display = "none";
            logo.style.transform = "rotate(0deg)";
        }
    })
})
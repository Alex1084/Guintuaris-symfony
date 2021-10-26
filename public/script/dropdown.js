const divs = document.querySelectorAll(".dropdown");
/* const dropdown = document.querySelector('.dropdown .dropdown-content'); */
divs.forEach((div) => {

    const button = div.querySelector(".dropbtn");
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
const divs = document.querySelectorAll(" .dropdown");
/* const dropdown = document.querySelector('.dropdown .dropdown-content'); */
 divs.forEach((div) => {

    const button = div.querySelector(".dropbtn"); 
    const dropdown = div.querySelector('.dropdown-content');
    const logo = div.querySelector('.drop-logo')
button.addEventListener('click', () => {
    console.log("wesh");
    if(dropdown.style.display != "block"){
        dropdown.style.display = "block"
        logo.style.transform = "rotate(90deg)";
    }
    else{
        logo.style.transform = "rotate(0deg)";
        div.style.display = "inline-block";
        dropdown.style.display = "none";
    }
})
}) 
window.addEventListener("DOMContentLoaded", (event) => {
    const classList = document.getElementById("class-list");
    const raceList = document.getElementById("race-list");
    fetch('/init-nav-bar')
    .then(response => response.json())
    .then(data => {
        for (let classe of data.classes) {
            classList.innerHTML += '<li class="nav-item"><a href="/classe/'+classe.slug+'">'+classe.name+'</a></li>'
        }
        for (let race of data.races) {
            raceList.innerHTML += '<li class="nav-item"><a href="/race/'+race.slug+'">'+race.name+'</a></li>'
        }
    })
});

const shownavside = document.getElementById("show-navside");
console.log(document.querySelector(".navside-container"));
const navside = document.querySelector(".navside")
if (document.querySelector(".navside-container") !== null)
{
    shownavside.addEventListener("click", e => {
        e.preventDefault();
        if (navside.classList.contains("navside-show")) {
            navside.classList.replace("navside-show","navside-hidden");
            setTimeout(() =>{
                shownavside.parentElement.classList.add("show")
            }, 600);
        }
        else {
            shownavside.parentElement.classList.remove("show")
            setTimeout(() =>{
                navside.classList.replace("navside-hidden","navside-show");
            }, 300);
        }
    })    
}

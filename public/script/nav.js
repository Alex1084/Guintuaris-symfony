window.addEventListener("DOMContentLoaded", (event) => {
    const classList = document.getElementById("class-list");
    const raceList = document.getElementById("race-list");
    axios.get("/init-nav-bar").then(function (response) {
        response.data.classes.forEach(classe => {
            classList.innerHTML += '<li class="nav-item"><a href="/classe/'+classe.slug+'">'+classe.name+'</a></li>'
        });
        response.data.races.forEach(race => {
            raceList.innerHTML += '<li class="nav-item"><a href="/race/'+race.slug+'">'+race.name+'</a></li>'
        });
    });
});

const shownavside = document.getElementById("show-navside");
const navside = document.querySelector(".navside")
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
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
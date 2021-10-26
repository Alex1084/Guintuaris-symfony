const btn = document.getElementById("menu-toggle")
const wrapperClass = document.getElementById("wrapper")
btn.addEventListener("click", (e) => {
    e.preventDefault();
    if (wrapperClass.classList.contains("menuDisplayed")) {
        wrapperClass.classList.remove("menuDisplayed")
    }

    else {
        wrapperClass.classList.add("menuDisplayed")
    }

})
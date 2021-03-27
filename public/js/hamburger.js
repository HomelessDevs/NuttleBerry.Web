/*---------------------------------hamburger-menu---------------------------------*/
var hamburger = document.getElementById("hamburger");
var menu = document.getElementById("nav-menu");
var stick = document.getElementsByClassName("stick")

function displayText() {
    if (menu.classList.contains("active")) {
        stick[0].classList.remove("first-stick");
        stick[1].classList.remove("second-stick");
        stick[2].classList.remove("third-stick");
        menu.classList.remove("active");
    } else {
        stick[0].classList.add("first-stick");
        stick[1].classList.add("second-stick");
        stick[2].classList.add("third-stick");
        menu.classList.add("active");
    }
};
hamburger.addEventListener("click", displayText, false);

function delMessage() {
    var el = document.getElementsByClassName('message-success');
    el[0].remove();
}

setTimeout(delMessage, 3000);

/*---------------------------------hamburger-menu---------------------------------*/
var button = document.getElementById("task-button");
var form = document.getElementById("edit-task");

function displayForm() {
    if (!button.classList.contains("task-button-rate")) {
        if (form.classList.contains("none-displayed")) {
            form.classList.remove("none-displayed");
        } else {
            form.classList.add("none-displayed");
        }
    }
};
button.addEventListener("click", displayForm, false);

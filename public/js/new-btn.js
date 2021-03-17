/*---------------------------------hamburger-menu---------------------------------*/
function displayForm(el) {
    if (el.id == "group-btn") {
        document.getElementById("group-form").classList.remove('none-displayed');
        document.getElementById("group-btn").classList.add('selected-btn');
        document.getElementById("task-form").classList.add('none-displayed');
        document.getElementById("course-form").classList.add('none-displayed');
        document.getElementById("course-btn").classList.remove('selected-btn');
        document.getElementById("task-btn").classList.remove('selected-btn');

    } else if (el.id == "course-btn") {
        document.getElementById("group-form").classList.add('none-displayed');
        document.getElementById("task-form").classList.add('none-displayed');
        document.getElementById("course-form").classList.remove('none-displayed');
        document.getElementById("course-btn").classList.add('selected-btn');
        document.getElementById("group-btn").classList.remove('selected-btn');
        document.getElementById("task-btn").classList.remove('selected-btn');

    } else if (el.id == "task-btn") {
        document.getElementById("group-form").classList.add('none-displayed');
        document.getElementById("task-form").classList.remove('none-displayed');
        document.getElementById("task-btn").classList.add('selected-btn');
        document.getElementById("course-form").classList.add('none-displayed');
        document.getElementById("course-btn").classList.remove('selected-btn');
        document.getElementById("group-btn").classList.remove('selected-btn');

    }
};


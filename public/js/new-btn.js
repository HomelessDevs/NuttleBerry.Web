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

function displayList(el) {
    if (el.id == "edit-course-btn") {
        document.getElementById("group-list").classList.add('none-displayed');
        document.getElementById("edit-course-btn").classList.add('selected-btn');
        document.getElementById("task-list").classList.add('none-displayed');
        document.getElementById("course-list").classList.add('none-displayed');

        document.getElementById("group-list-form").classList.remove('none-displayed');
        document.getElementById("course-list-form").classList.remove('none-displayed');
        document.getElementById("task-list-form").classList.remove('none-displayed');


        document.getElementById("create-course-btn").classList.remove('selected-btn');

    } else if (el.id == "create-course-btn") {
        document.getElementById("group-list").classList.remove('none-displayed');
        document.getElementById("edit-course-btn").classList.remove('selected-btn');



        document.getElementById("group-list-form").classList.add('none-displayed');
        document.getElementById("course-list-form").classList.add('none-displayed');
        document.getElementById("task-list-form").classList.add('none-displayed');

        document.getElementById("task-list").classList.remove('none-displayed');
        document.getElementById("course-list").classList.remove('none-displayed');
        document.getElementById("create-course-btn").classList.add('selected-btn');
    }
};


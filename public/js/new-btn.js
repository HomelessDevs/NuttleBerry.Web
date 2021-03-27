let selectedSessionMethod = document.getElementById(sessionStorage.getItem('method'))
displayList(selectedSessionMethod);
let selectedSessionCourse = document.getElementById(sessionStorage.getItem('course'))
displayForm(selectedSessionCourse);
function displayForm(el) {
    sessionStorage.setItem('course', el.id);
    document.getElementById("courses-block").classList.remove('none-displayed');
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
    if (el.id == "create-course-btn") {
        document.getElementById("group-list").classList.add('none-displayed');
        document.getElementById("task-list").classList.add('none-displayed');
        document.getElementById("course-list").classList.add('none-displayed');
        document.getElementById("group-list-form").classList.remove('none-displayed');
        document.getElementById("course-list-form").classList.remove('none-displayed');
        document.getElementById("task-list-form").classList.remove('none-displayed');
        document.getElementById("create-course-btn").classList.add('selected-btn');
        document.getElementById("edit-course-btn").classList.remove('selected-btn');
    } else if (el.id == "edit-course-btn") {
        document.getElementById("create-course-btn").classList.remove('selected-btn');
        document.getElementById("edit-course-btn").classList.add('selected-btn');
        document.getElementById("group-list").classList.remove('none-displayed');
        document.getElementById("group-list-form").classList.add('none-displayed');
        document.getElementById("course-list-form").classList.add('none-displayed');
        document.getElementById("task-list-form").classList.add('none-displayed');
        document.getElementById("task-list").classList.remove('none-displayed');
        document.getElementById("course-list").classList.remove('none-displayed');
    }
    sessionStorage.setItem('method', el.id);
    document.getElementById("courses-btns-block").classList.remove('none-displayed');
};




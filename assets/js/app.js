const addTaskButton = document.getElementById("add-task-button");
const modal = document.getElementById("modal-task");
const modalHeader = modal.querySelector("#modal-header-title");
const modalTitleForm = modal.querySelector("#title-of-task");
const modalTypeFeatureForm = modal.querySelector("#feature-radio");
const modalTypeBugForm = modal.querySelector("#bug-radio");
const modalPriorityForm = modal.querySelector("#add-task-priority");
const modalStatusForm = modal.querySelector("#add-task-status");
const modalDateForm = modal.querySelector("#add-task-date");
const modalDescriptionForm = modal.querySelector("#add-task-description");

const modalCloseButton = document.getElementById("add-task-close");
const modalEditButton = document.getElementById("add-task-edit");
const modalDeleteButton = document.getElementById("add-task-delete");
const modalUpdateButton = document.getElementById("add-task-update");
const modalSaveChangesButton = document.getElementById("add-task-save-changes");

let newTaskId = tasks.length + 1;
let editedTask;

const tasksCounters = {"To Do": 0, "In Progress": 0, "Done": 0};

const tasksBodies = {
                    "To Do": document.getElementById("to-do-tasks"),
                    "In Progress": document.getElementById("in-progress-tasks"),
                    "Done": document.getElementById("done-tasks"), 
                };

const tasksHeaderCounter = {
                    "To Do": document.getElementById("todo-tasks-count"),
                    "In Progress": document.getElementById("in-progress-tasks-count"),
                    "Done": document.getElementById("done-tasks-count"),
                    };

const cardsButtonClasses = ["task-card", "border-0", "w-100", "py-2", "px-1", "d-flex"];

const icons = {
                "To Do":'<i class="bi bi-question-circle"></i>',
                "In Progress":'<i class="spinner-border spinner-border-sm"></i>',
                "Done":'<i class="bi bi-check-circle"></i>',
            };

const mapIdStatus = {"to-do-tasks": "To Do", "in-progress-tasks": "In Progress", "done-tasks": "Done"};

const COLUMNS = ["To Do", "In Progress", "Done"];

function validateInput(task) {
    if (task.title == ""
    ||  task.date == ""
    ||  task.description == ""
    ||  task.priority == ""
    ||  task.status == ""
    ||  task.type == "") {
        return false;
    } else
        return true;
}

function addNewTask(task) {
    let newTask = document.createElement("button");
    newTask.id = task.id;
    newTask.classList.add(...cardsButtonClasses);
    newTask.setAttribute("draggable", "true");

    newTask.innerHTML += `
                            <div class="text-success px-2 fs-5 task-icon">
                            </div>
                            <div class="text-start">
                                <div class="fw-bolder fs-13px">${task.title}</div>
                                <div class="fs-6">
                                    <div class="text-secondary">#${task.id} created in ${task.date}</div>
                                    <div class="task-description" title="${task.description}">${task.description}</div>
                                </div>
                                <div class="py-2">
                                    <span class="bg-primary text-white rounded-2 p-1 px-2">${task.priority}</span>
                                    <span class="bg-light-600 rounded-2 p-1 px-2">${task.type}</span>
                                </div>
                            </div>
                        `;
    
    const iconElement = newTask.querySelector(".task-icon");
    newTask.addEventListener("click", editTask);
    newTask.addEventListener("dragstart", dragStart);
    newTask.addEventListener("dragend", dragEnd);
    let status = task["status"];

    iconElement.innerHTML = icons[status];
    tasksHeaderCounter[status].innerHTML = ++tasksCounters[status];
    tasksBodies[status].appendChild(newTask);
}

function loadTasksData(tasks) { 
    tasks.forEach(task => addNewTask(task));
}

function createTask() {
    modalHeader.innerText = "Add task";
    modal.reset();

    modalUpdateButton.hidden = true;
    modalDeleteButton.hidden = true;
    modalSaveChangesButton.hidden = false;

    showModal();
}

function saveTask() {
    let task = fillTask();

    if(validateInput(task)) {
        task["id"] = newTaskId++;
        tasks.push(task);

        addNewTask(task);

        hideModal();
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Saved',
            showConfirmButton: false,
            timer: 1000
        });
    } else {
        alert("not enough input for the new task");
    }
}

function editTask() {
    modal.reset();
    modalHeader.innerText = "Edit task";

    modalUpdateButton.hidden = false;
    modalDeleteButton.hidden = false;
    modalSaveChangesButton.hidden = true;

    let index = getIndexOftask(this.id);
    task = tasks[index];

    fillModalByTask(task);

    editedTask = {"index": index, "id": this.id};
    showModal();
}

function fillModalByTask(task) {
    modalTitleForm.value = task["title"];
    modalTypeFeatureForm.checked = task["type"] == "Feature";
    modalTypeBugForm.checked = task["type"] == "Bug";
    modalPriorityForm.value = task["priority"];
    modalStatusForm.value = task["status"];
    modalDateForm.value = task["date"];
    modalDescriptionForm.value = task["description"];
}

function getIndexOftask(id) {
    for (let i=0; i<tasks.length; i++)
        if (tasks[i].id == id)
            return i;
}

function fillTask() {
    let task = {};

    task["type"] = modalTypeFeatureForm.checked ? "Feature" : "Bug"; 
    task["title"] = modalTitleForm.value;
    task["priority"] = modalPriorityForm.value;
    task["status"] = modalStatusForm.value;
    task["date"] = modalDateForm.value;
    task["description"] = modalDescriptionForm.value;

    return task;
}

function updateTask() {
    let task = fillTask();

    if(validateInput(task)) {
        task["id"] = editedTask["id"];
        tasks[editedTask["index"]] = task;
        hideModal();
        reloadTasks();
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Saved',
            showConfirmButton: false,
            timer: 1000
        });
    } else {
        alert("not enough input for updating the task");
    }
}

function deleteTask() {
    Swal.fire({
        title: 'Are you sure you want to delete the task?',
        showDenyButton: true,
        confirmButtonText: 'Delete',
        denyButtonText: `Cancel`,
    }).then((result) => {
        if (result.isConfirmed) {
            let taskId = editedTask["id"];
            let taskIndex = editedTask["index"];
            let status = tasks[taskIndex]["status"];

            tasksHeaderCounter[status].innerText = --tasksCounters[status];

            tasks.splice(taskIndex, 1);
            document.getElementById(taskId).remove();

            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Task deleted with success',
                showConfirmButton: false,
                timer: 1000
            });
        }
    });
    hideModal();
}

function reloadTasks() {
    let tasksElements = document.querySelectorAll(".task-card");
    for(let taskElem of tasksElements) {
        taskElem.remove();
    }

    COLUMNS.forEach(column => {     //set all counters and columns headers to 0
        tasksHeaderCounter[column].innerText = tasksCounters[column] = 0;
    })

    loadTasksData(tasks);
}

function showModal() {
    $("#modal-task").modal("show");
}

function hideModal() {
    $("#modal-task").modal("hide");
}

function dragStart(e) {
    e.dataTransfer.setData("text", e.target.id);
    this.style.opacity = 0.4;
}

function dragEnd(e) {
    this.style.opacity = 1;
}

function dragOver(e) {
    e.preventDefault();
}

function dragDrop(e) {
    let taskId = e.dataTransfer.getData("text");
    let status = mapIdStatus[this.id];
    let taskIndex = getIndexOftask(taskId);
    task = tasks[taskIndex];
    if (status != task["status"]) {
        task["status"] = status;
        tasks.splice(taskIndex, 1);
        let i;
        for(i=0; i<tasks.length; i++) { // to put it first in its section
            if(tasks[i].status == status)
                break;
        }
        tasks.splice(i, 0, task);
        reloadTasks();
    }
}

loadTasksData(tasks); // chargement des tasks de data.js

modalSaveChangesButton.addEventListener("click", saveTask);
addTaskButton.addEventListener("click", createTask);
modalDeleteButton.addEventListener("click", deleteTask);
modalUpdateButton.addEventListener("click", updateTask);

Object.values(tasksBodies).forEach(x => {
    x.addEventListener("dragover", dragOver);
    x.addEventListener("drop", dragDrop);
});


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
const modalTaskId = modal.querySelector("#add-task-id");

const modalCloseButton = document.getElementById("add-task-close");
const modalEditButton = document.getElementById("add-task-edit");
const modalDeleteButton = document.getElementById("add-task-delete");
const modalUpdateButton = document.getElementById("add-task-update");
const modalSaveChangesButton = document.getElementById("add-task-save-changes");

const tasksBodies = {
                    "To Do": document.getElementById("to-do-tasks"),
                    "In Progress": document.getElementById("in-progress-tasks"),
                    "Done": document.getElementById("done-tasks"), 
                };

const mapIdStatus = {"to-do-tasks": "To Do", "in-progress-tasks": "In Progress", "done-tasks": "Done"};

function showModal() {
    $("#modal-task").modal("show");
}

function hideModal() {
    $("#modal-task").modal("hide");
}

function editTask() {
    modal.reset();
    modalHeader.innerText = "Edit task";

    modalUpdateButton.hidden = false;
    modalDeleteButton.hidden = false;
    modalSaveChangesButton.hidden = true;

    fillModal(this);

    showModal();
}

function createTask() {
    modalHeader.innerText = "Add task";
    modal.reset();

    modalUpdateButton.hidden = true;
    modalDeleteButton.hidden = true;
    modalSaveChangesButton.hidden = false;

    showModal();
}

function fillModal(b) {
    modalTaskId.value = b.id;
    modalTitleForm.value = b.querySelector(".title").innerText;
    modalTypeFeatureForm.checked = b.querySelector(".type").innerText == "Feature" ;
    modalTypeBugForm.checked = b.querySelector(".type").innerText == "Bug";
    modalPriorityForm.value = b.querySelector(".priority").innerText;
    modalStatusForm.value = b.dataset.status;
    modalDateForm.value = b.dataset.date.split(' ')[0];
    modalDescriptionForm.value = b.querySelector(".description").title;
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
    const task = document.getElementById(taskId);
    let status = mapIdStatus[this.id];

    if (status != task.dataset.status) {
        modalTaskId.value = task.id;
        modalTitleForm.value = task.querySelector(".title").innerText;
        modalTypeFeatureForm.checked = task.querySelector(".type").innerText == "Feature" ;
        modalTypeBugForm.checked = task.querySelector(".type").innerText == "Bug";
        modalPriorityForm.value = task.querySelector(".priority").innerText;
        modalStatusForm.value = status;
        modalDateForm.value = task.dataset.date.split(' ')[0];
        modalDescriptionForm.value = task.querySelector(".description").title;
        modalUpdateButton.click();
    }
}

Object.values(tasksBodies).forEach(x => {
    x.addEventListener("dragover", dragOver);
    x.addEventListener("drop", dragDrop);
});

document.querySelectorAll(".task-card").forEach(b => {
    b.addEventListener("click", editTask);
    b.addEventListener("dragstart", dragStart);
    b.addEventListener("dragend", dragEnd);
    b.setAttribute("draggable", "true");
});

addTaskButton.addEventListener("click", createTask);
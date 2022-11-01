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

document.querySelectorAll(".task-card").forEach(b => {
    b.addEventListener("click", editTask);
});

addTaskButton.addEventListener("click", createTask);
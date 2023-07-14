const inputForm = document.querySelector(".input-group");
const input = inputForm.querySelector(".form-control");
const formChecks = document.querySelectorAll(".form-check");
const sortings = [
    {
        name: "Ascending numbers",
        field: "data_id",
        order: "asc"
    },
    {
        name: "Descending numbers",
        field: "data_id",
        order: "desc"
    },
    {
        name: "In alphabetical order",
        field: "name",
        order: "asc"
    },
    {
        name: "In reverse alphabetical order",
        field: "name",
        order: "desc"
    }
];

let editId = -1;

inputForm.addEventListener("submit", (event) => {
    if (!checkNameValidity(input.value)) {
        event.preventDefault();
        if (input.classList.contains("is-invalid")) return;
        input.classList.add("is-invalid");
    }
});

input.addEventListener("keydown", (event) => {
    if (!input.classList.contains("is-invalid")) return;
    input.classList.remove("is-invalid");
});

for (let i = 0; i < formChecks.length; i++) {
    formChecks[i].querySelector("label").textContent = sortings[i].name;
    formChecks[i].addEventListener("click", () => {
        window.location.href = `?sort_field=${sortings[i].field}&sort_order=${sortings[i].order}`;
    });
}

function checkNameValidity(name) {
    const re = /[^ ]+/;
    return re.test(name);
}

function activeEditing(event, item) {
    if (editId !== -1) {
        event.preventDefault();
        return;
    }
    const li = event.target.closest("li");
    li.querySelector(".editMode").classList.toggle("hidden");
    li.querySelector(".nonEditMode").classList.toggle("hidden");
    editId = item.data_id;
    event.target.closest("li").querySelector(".itemInput").value = item.name;
}

function cancelRenaming(event) {
    const li = event.target.closest("li");
    li.querySelector(".editMode").classList.toggle("hidden");
    li.querySelector(".nonEditMode").classList.toggle("hidden");
    editId = -1;
}
const newImageBtn = document.querySelector(".btn.position-absolute");
const pictureInput = document.querySelector(".picture-input");
const tokenInputGroup = document.querySelector(".input-group");
const tokenInput = tokenInputGroup.querySelector("input");
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

newImageBtn.addEventListener("click", (event) => {
    pictureInput.onchange = () =>
        document.querySelector("#image-post-form").submit();

    pictureInput.click();
});

tokenInputGroup.addEventListener("submit", (event) => {
    event.preventDefault();
    tryAddToken(tokenInput.value).then((response) => {
        if (response) {
            if (!tokenInput.classList.contains("is-valid"))
                tokenInput.classList.add("is-valid");
        } else {
            if (!tokenInput.classList.contains("is-invalid"))
                tokenInput.classList.add("is-invalid");
        }
    });
});

tokenInput.addEventListener("keydown", (event) => {
    if (tokenInput.classList.contains("is-valid"))
        tokenInput.classList.remove("is-valid");
    if (tokenInput.classList.contains("is-invalid"));
    tokenInput.classList.remove("is-invalid");
});

async function tryAddToken(value) {
    return await fetch("/add-token", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            token: value,
        }),
    })
        .then((response) => response.json())
        .then((data) => data.valid);
}

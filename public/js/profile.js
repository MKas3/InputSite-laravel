const newImageBtn = document.querySelector(".btn.position-absolute");
const input = document.querySelector('.picture-input');

newImageBtn.addEventListener("click", (event) => {
    input.onchange = () => document.querySelector('#image-post-form').submit();

    input.click();
});

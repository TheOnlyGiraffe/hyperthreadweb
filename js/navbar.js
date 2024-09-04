
const mobileBtn = document.querySelector(".mobile-btn");

mobileBtn.addEventListener("click", () => {
    mobileBtn.classList.toggle("mobile-active");
});

window.addEventListener("resize", () => {
    mobileBtn.classList.remove("mobile-active");
});
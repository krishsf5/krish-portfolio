import "./bootstrap";
import "../css/app.css";

document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".card");

    elements.forEach((el, i) => {
        el.style.opacity = 0;
        el.style.transform = "translateY(20px)";

        setTimeout(() => {
            el.style.transition = "all .6s ease";
            el.style.opacity = 1;
            el.style.transform = "translateY(0)";
        }, i * 120);
    });
});

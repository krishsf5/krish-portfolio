/* --------------------------------------------------
   TECH STACK PARALLAX — rAF throttled
-------------------------------------------------- */

export default function initTechParallax() {
    const columns = document.querySelectorAll(".tech-column");

    if (!columns.length) return;

    let ticking = false;

    window.addEventListener("scroll", () => {
        if (ticking) return;

        ticking = true;

        requestAnimationFrame(() => {
            const scrollY = window.scrollY;

            columns.forEach((col, index) => {
                col.style.transform = `translateY(${scrollY * (index + 1) * 0.01}px)`;
            });

            ticking = false;
        });
    });
}

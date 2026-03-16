/* --------------------------------------------------
   CURSOR GLOW (GPU optimized)
-------------------------------------------------- */

export default function initCursorGlow() {

    const glow = document.createElement("div")

    glow.className = "cursor-glow"

    document.body.appendChild(glow)

    let mouseX = 0
    let mouseY = 0

    document.addEventListener("mousemove", (e) => {

        mouseX = e.clientX
        mouseY = e.clientY

    })

    function animateGlow() {

        glow.style.transform = `translate(${mouseX}px, ${mouseY}px) translate(-50%, -50%)`

        requestAnimationFrame(animateGlow)

    }

    animateGlow()

}

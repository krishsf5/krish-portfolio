/* --------------------------------------------------
   CURSOR GLOW
-------------------------------------------------- */

export default function initCursorGlow() {

    const glow = document.createElement('div')
    glow.className = 'cursor-glow'
    document.body.appendChild(glow)

    document.addEventListener('mousemove', (e) => {
        glow.style.transform = `translate(${e.clientX}px, ${e.clientY}px) translate(-50%, -50%)`
    })

}

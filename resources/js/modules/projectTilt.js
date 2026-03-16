/* --------------------------------------------------
   PROJECT CARD TILT INTERACTION
-------------------------------------------------- */

export default function initProjectTilt() {

    const cards = document.querySelectorAll(".project-card")

    if (!cards.length) return

    cards.forEach(card => {

        card.addEventListener("mousemove", e => {

            const rect = card.getBoundingClientRect()

            const x = e.clientX - rect.left
            const y = e.clientY - rect.top

            const centerX = rect.width / 2
            const centerY = rect.height / 2

            const rotateX = -(y - centerY) / 15
            const rotateY = (x - centerX) / 15

            card.style.transform =
                `perspective(900px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`

        })

        card.addEventListener("mouseleave", () => {

            card.style.transform =
                "perspective(900px) rotateX(0) rotateY(0) scale(1)"

        })

    })

}

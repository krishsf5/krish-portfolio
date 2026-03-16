/* --------------------------------------------------
   SCROLL REVEAL
-------------------------------------------------- */

export default function initScrollReveal() {

    const revealElements = document.querySelectorAll(".reveal")

    if (!revealElements.length) return

    const observer = new IntersectionObserver(

        (entries, observer) => {

            entries.forEach(entry => {

                if (!entry.isIntersecting) return

                entry.target.classList.add("revealed")

                observer.unobserve(entry.target)

            })

        },

        {
            threshold: 0.15
        }

    )

    revealElements.forEach(el => observer.observe(el))

}

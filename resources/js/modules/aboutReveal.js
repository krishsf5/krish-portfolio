export function initAboutReveal() {

    const section = document.querySelector("#about")

    if (!section) return

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {
                section.classList.add("opacity-100", "translate-y-0")
            }

        })

    }, { threshold: 0.2 })

    section.classList.add(
        "opacity-0",
        "translate-y-12",
        "transition",
        "duration-1000"
    )

    observer.observe(section)

}

import "./bootstrap"
import "../css/app.css"

import initScrollReveal   from "./modules/scrollReveal"
import initCursorGlow     from "./modules/cursorGlow"
import initTechStackDrag  from "./modules/techStackDrag"
import initTechParallax   from "./modules/techParallax"
import initProjectTilt    from "./modules/projectTilt"
import initGsapAnimations from "./modules/gsapAnimations"

document.addEventListener("DOMContentLoaded", () => {
    initScrollReveal()
    initCursorGlow()
    initTechStackDrag()
    initTechParallax()
    initProjectTilt()
    requestAnimationFrame(() => initGsapAnimations())
})

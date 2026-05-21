import "./bootstrap"
import "../css/app.css"

import initScrollReveal   from "./modules/scrollReveal"
import initCursorGlow     from "./modules/cursorGlow"
import initGsapAnimations from "./modules/gsapAnimations"

document.addEventListener("DOMContentLoaded", () => {
    initScrollReveal()
    initCursorGlow()
    requestAnimationFrame(() => initGsapAnimations())
})

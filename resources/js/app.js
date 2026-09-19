import "./bootstrap"
import "../css/app.css"

import 'trix';
import 'trix/dist/trix.css';

import initScrollReveal   from "./modules/scrollReveal"
import initCursorGlow     from "./modules/cursorGlow"
import initGsapAnimations from "./modules/gsapAnimations"
import initSmoothScroll   from "./modules/smoothScroll"

document.addEventListener("DOMContentLoaded", () => {
    initSmoothScroll()
    initScrollReveal()
    initCursorGlow()
    requestAnimationFrame(() => initGsapAnimations())
})

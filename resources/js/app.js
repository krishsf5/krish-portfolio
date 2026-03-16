import { Sortable } from "@shopify/draggable"

import "./bootstrap"
import "../css/app.css"

import initCardAnimations from "./modules/cardAnimations"
import initScrollReveal from "./modules/scrollReveal"
import initCursorGlow from "./modules/cursorGlow"
import initTechStackDrag from "./modules/techStackDrag"
import initTechParallax from "./modules/techParallax"
import initProjectTilt from "./modules/projectTilt"
import { initAboutReveal } from "./modules/aboutReveal"

/* --------------------------------------------------
   INITIALIZE AFTER DOM READY
-------------------------------------------------- */

document.addEventListener("DOMContentLoaded", () => {

    initCardAnimations()

    initScrollReveal()

    initCursorGlow()

    initTechStackDrag()

    initTechParallax()

    initProjectTilt()

    initAboutReveal()

})

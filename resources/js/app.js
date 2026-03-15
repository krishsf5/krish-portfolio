import { Sortable } from "@shopify/draggable"

import "./bootstrap"
import "../css/app.css"

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

})

/* --------------------------------------------------
   CARD ENTRANCE ANIMATION
-------------------------------------------------- */

function initCardAnimations() {

    const cards = document.querySelectorAll(".card")

    cards.forEach((card, index) => {

        card.style.opacity = "0"
        card.style.transform = "translateY(20px)"

        setTimeout(() => {

            card.style.transition = "all .6s ease"
            card.style.opacity = "1"
            card.style.transform = "translateY(0)"

        }, index * 120)

    })

}

/* --------------------------------------------------
   SCROLL REVEAL
-------------------------------------------------- */

function initScrollReveal() {

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

/* --------------------------------------------------
   CURSOR GLOW (GPU optimized)
-------------------------------------------------- */

function initCursorGlow() {

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

/* --------------------------------------------------
   TECH STACK DRAGGING
-------------------------------------------------- */

function initTechStackDrag() {

    const columns = document.querySelectorAll(".tech-list")

    if (!columns.length) return

    columns.forEach(column => {

        new Sortable(column, {

            draggable: ".tech-card",

            mirror: {
                constrainDimensions: true
            },

            plugins: [],

            delay: 100

        })

    })

}

/* --------------------------------------------------
   TECH STACK PARALLAX
-------------------------------------------------- */

function initTechParallax(){

    const columns=document.querySelectorAll(".tech-column")

    window.addEventListener("scroll",()=>{

        const scrollY=window.scrollY

        columns.forEach((col,index)=>{

            const speed=(index+1)*0.05

            col.style.transform=`translateY(${scrollY*speed*0.2}px)`

        })

    })

}

/* --------------------------------------------------
   PROJECT CARD TILT INTERACTION
-------------------------------------------------- */

function initProjectTilt() {

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

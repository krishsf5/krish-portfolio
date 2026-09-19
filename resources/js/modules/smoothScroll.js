import Lenis from 'lenis'
import 'lenis/dist/lenis.css'

let lenisInstance = null

export default function initSmoothScroll() {
    if (lenisInstance) {
        lenisInstance.destroy()
    }

    const lenis = new Lenis({
        duration: 1.5, // Generous, luxurious duration so it feels soft and relaxed
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Smooth exponential deceleration
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 0.85, // Moderated wheel speed so mouse scroll isn't too fast
        touchMultiplier: 1.2,
        infinite: false,
    })

    lenisInstance = lenis
    window.lenis = lenis

    // Sync with GSAP ScrollTrigger if loaded
    if (window.ScrollTrigger && window.gsap) {
        lenis.on('scroll', window.ScrollTrigger.update)
        window.gsap.ticker.add((time) => {
            lenis.raf(time * 1000)
        })
        window.gsap.ticker.lagSmoothing(0)
    } else {
        function raf(time) {
            lenis.raf(time)
            requestAnimationFrame(raf)
        }
        requestAnimationFrame(raf)
    }

    // Intercept in-page anchor clicks for smooth, elegant animated scrolling
    const handleAnchorClick = (e) => {
        const anchor = e.target.closest('a[href*="#"]')
        if (!anchor) return

        const href = anchor.getAttribute('href')
        if (!href || href === '#') return

        const hashIndex = href.indexOf('#')
        if (hashIndex === -1) return

        const path = href.slice(0, hashIndex)
        const hash = href.slice(hashIndex)

        const currentPath = window.location.pathname
        if (path && path !== currentPath && !(path === '/' && currentPath === '/')) {
            return
        }

        const target = document.querySelector(hash)
        if (target) {
            e.preventDefault()
            lenis.scrollTo(target, {
                offset: 0,
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            })

            if (history.pushState) {
                history.pushState(null, null, hash)
            }
        }
    }

    document.removeEventListener('click', handleAnchorClick)
    document.addEventListener('click', handleAnchorClick)

    // Handle initial hash if page is opened with anchor
    if (window.location.hash) {
        const initialTarget = document.querySelector(window.location.hash)
        if (initialTarget) {
            setTimeout(() => {
                lenis.scrollTo(initialTarget, { offset: 0, immediate: true })
            }, 100)
        }
    }

    // Handle Livewire page navigations
    document.addEventListener('livewire:navigated', () => {
        lenis.resize()
        if (window.location.hash) {
            const initialTarget = document.querySelector(window.location.hash)
            if (initialTarget) {
                setTimeout(() => {
                    lenis.scrollTo(initialTarget, { offset: 0, immediate: true })
                }, 100)
            }
        }
    })

    return lenis
}

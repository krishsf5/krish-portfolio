/* --------------------------------------------------
   GSAP ANIMATIONS — hero, about, sections, counters
   GSAP + ScrollTrigger loaded via CDN (globals)
-------------------------------------------------- */

export default function initGsapAnimations() {

    if (!window.gsap || !window.ScrollTrigger) return

    gsap.registerPlugin(ScrollTrigger)


    // --------------------------------------------------
    // HERO — entrance timeline
    // --------------------------------------------------
    const heroTl = gsap.timeline({ delay: 0.2 })

    heroTl
        .from('[data-hero-badge]', {
            opacity: 0,
            y: 24,
            duration: 0.7,
            ease: 'power3.out',
        })
        .from('[data-hero-title]', {
            opacity: 0,
            y: 48,
            duration: 0.9,
            ease: 'power3.out',
        }, '-=0.4')
        .from('[data-hero-sub]', {
            opacity: 0,
            y: 24,
            duration: 0.7,
            ease: 'power3.out',
        }, '-=0.5')
        .from('[data-hero-btns]', {
            opacity: 0,
            y: 20,
            duration: 0.6,
            ease: 'power3.out',
        }, '-=0.4')
        .from('[data-hero-card]', {
            opacity: 0,
            x: 60,
            duration: 1,
            ease: 'back.out(1.2)',
        }, '-=0.7')
        .from('.badge-float', {
            opacity: 0,
            scale: 0.5,
            duration: 0.5,
            stagger: 0.12,
            ease: 'back.out(2)',
        }, '-=0.4')


    // --------------------------------------------------
    // SCROLL LINE on hero
    // --------------------------------------------------
    gsap.from('.scroll-line', {
        scaleY: 0,
        transformOrigin: 'top',
        duration: 1.2,
        ease: 'power2.out',
        delay: 1.5,
    })


    // --------------------------------------------------
    // ABOUT — scroll-triggered reveal
    // --------------------------------------------------
    ScrollTrigger.create({
        trigger: '#about',
        start: 'top 65%',
        once: true,
        onEnter: () => {

            gsap.from('[data-about-label]', {
                opacity: 0,
                x: -30,
                duration: 0.7,
                ease: 'power3.out',
            })

            gsap.from('[data-about-photo]', {
                opacity: 0,
                x: -60,
                duration: 1,
                ease: 'power3.out',
                delay: 0.15,
            })

            gsap.from('[data-about-text]', {
                opacity: 0,
                x: 60,
                duration: 1,
                ease: 'power3.out',
                delay: 0.25,
            })

            gsap.from('[data-about-text] .stat-counter-card', {
                opacity: 0,
                y: 30,
                duration: 0.5,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.5,
            })

        },
    })


    // --------------------------------------------------
    // COUNTER ANIMATION
    // --------------------------------------------------
    document.querySelectorAll('.counter-val').forEach(el => {

        const target   = parseInt(el.dataset.count, 10)
        const suffix   = el.dataset.suffix || ''
        let triggered  = false

        ScrollTrigger.create({
            trigger: el,
            start: 'top 85%',
            once: true,
            onEnter: () => {

                if (triggered) return
                triggered = true

                const obj = { val: 0 }

                gsap.to(obj, {
                    val: target,
                    duration: 2,
                    ease: 'power2.out',
                    onUpdate() {
                        el.textContent = Math.ceil(obj.val) + suffix
                    },
                    onComplete() {
                        el.textContent = target + suffix
                    },
                })

            },
        })

    })


    // --------------------------------------------------
    // SECTION LABELS + HEADINGS
    // --------------------------------------------------
    document.querySelectorAll('[data-section-label]').forEach(el => {
        gsap.from(el, {
            scrollTrigger: { trigger: el, start: 'top 80%', once: true },
            opacity: 0,
            x: -30,
            duration: 0.7,
            ease: 'power3.out',
        })
    })

    document.querySelectorAll('[data-section-heading]').forEach(el => {
        gsap.from(el, {
            scrollTrigger: { trigger: el, start: 'top 80%', once: true },
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out',
        })
    })


    // --------------------------------------------------
    // TECH STACK CATEGORY CARDS
    // --------------------------------------------------
    gsap.from('[data-category-card]', {
        scrollTrigger: {
            trigger: '[data-category-card]',
            start: 'top 80%',
            once: true,
        },
        opacity: 0,
        y: 40,
        duration: 0.6,
        stagger: 0.12,
        ease: 'power2.out',
    })


    // --------------------------------------------------
    // PROJECTS SWIPER ENTRANCE
    // --------------------------------------------------
    gsap.from('.proj-outer', {
        scrollTrigger: {
            trigger: '.proj-outer',
            start: 'top 80%',
            once: true,
        },
        opacity: 0,
        y: 50,
        duration: 0.9,
        ease: 'power3.out',
    })

}

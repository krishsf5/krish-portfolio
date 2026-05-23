@props(['projects'])

@php $uid = 'pslider_' . uniqid(); @endphp

{{-- ─── Styles (scoped via .proj-outer) ──────────────────────────────────── --}}
<style>
    /* ── Track & outer ─────────────────────────────────────────── */
    .proj-outer {
        position: relative;
        width: 100%;
        overflow: hidden;   /* clip rotated/scaled cards cleanly */
    }

    .proj-track {
        display: flex;
        align-items: center;
        gap: 28px;
        overflow-x: scroll;
        overflow-y: visible; /* allow subtle scale without clip */
        scroll-behavior: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        cursor: grab;
        padding: 20px 0 28px;   /* vertical room for scale + dots */
        /* horizontal padding = half the outer width so center slide is truly centered */
        padding-left:  calc(50% - var(--slide-w, 320px) / 2);
        padding-right: calc(50% - var(--slide-w, 320px) / 2);
    }
    .proj-track::-webkit-scrollbar { display: none; }

    /* ── Slide shell ────────────────────────────────────────────── */
    .proj-slide {
        flex: 0 0 var(--slide-w, 320px);
        width: var(--slide-w, 320px);
        will-change: transform, opacity;
        transition: transform 0.15s ease, opacity 0.15s ease;
    }

    /* ── Card: FIXED HEIGHT ─────────────────────────────────────── */
    .pcard {
        background: var(--card-bg, #ffffff);
        border: 1px solid rgba(148,163,184,0.18);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 400px;          /* ← fixed height */
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .dark .pcard {
        --card-bg: #0f172a;
        border-color: rgba(148,163,184,0.10);
        box-shadow: 0 4px 24px rgba(0,0,0,0.3);
    }

    /* ── Image zone (fixed height) ──────────────────────────────── */
    .pcard__img {
        position: relative;
        height: 170px;
        flex-shrink: 0;
        overflow: hidden;
        background: #0f172a;
    }

    .pcard__thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pcard__placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(148,163,184,0.35);
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    .pcard__img-fade {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 48px;
        background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.45));
        pointer-events: none;
    }

    /* accent strip */
    .pcard__accent {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        z-index: 2;
    }
    .pcard__accent--live { background: linear-gradient(90deg,#22d3ee,#6366f1); }
    .pcard__accent--wip  { background: linear-gradient(90deg,#f59e0b,#ef4444); }
    .pcard__accent--dim  { background: rgba(148,163,184,0.2); }

    /* badge */
    .pcard__badge {
        position: absolute;
        bottom: 10px; right: 10px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .1em;
        padding: 3px 8px;
        border-radius: 99px;
        z-index: 3;
    }
    .pcard__badge--live { background: rgba(34,211,238,.15); color: #22d3ee; border: 1px solid rgba(34,211,238,.3); }
    .pcard__badge--wip  { background: rgba(245,158,11,.15); color: #f59e0b; border: 1px solid rgba(245,158,11,.3); }

    .pcard__dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
        display: inline-block;
    }
    .pcard__dot--pulse {
        animation: dotpulse 1.6s ease-in-out infinite;
    }
    @keyframes dotpulse {
        0%,100% { opacity:1; transform:scale(1); }
        50%      { opacity:.4; transform:scale(.7); }
    }

    /* ── Body: flex-grow so it fills remaining card height ─────── */
    .pcard__body {
        flex: 1 1 0;
        min-height: 0;          /* let flex shrink work */
        display: flex;
        flex-direction: column;
        padding: 14px 16px 14px;
        overflow: hidden;
    }

    .pcard__title-link {
        text-decoration: none;
        display: block;
        flex-shrink: 0;
    }
    .pcard__title {
        font-size: 15px;
        font-weight: 700;
        line-height: 1.3;
        color: #0f172a;
        margin: 0 0 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dark .pcard__title { color: #f1f5f9; }

    /* Description: clamped to 3 lines */
    .pcard__desc {
        font-size: 13px;
        line-height: 1.55;
        color: #64748b;
        margin: 0 0 10px;
        flex-shrink: 0;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dark .pcard__desc { color: #94a3b8; }

    /* Tags */
    .pcard__tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 10px;
        flex-shrink: 0;
    }
    .pcard__tag {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .05em;
        padding: 2px 8px;
        border-radius: 99px;
        background: rgba(99,102,241,.1);
        color: #6366f1;
        border: 1px solid rgba(99,102,241,.2);
    }
    .dark .pcard__tag {
        background: rgba(99,102,241,.15);
        color: #a5b4fc;
        border-color: rgba(99,102,241,.25);
    }
    .pcard__tag--more {
        background: rgba(148,163,184,.1);
        color: #64748b;
        border-color: rgba(148,163,184,.2);
    }

    /* Links row */
    .pcard__links {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .pcard__link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        padding: 3px 0;
        transition: opacity .15s;
    }
    .pcard__link:hover { opacity: .7; }
    .pcard__link--live { color: #22d3ee; }
    .pcard__link--repo { color: #94a3b8; }
    .pcard__sep { color: rgba(148,163,184,.4); font-size: 14px; }
    .pcard__no-links { font-size: 11px; color: rgba(148,163,184,.5); }

    /* ── "View project" CTA — pushed to bottom ──────────────────── */
    .pcard__cta {
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid rgba(148,163,184,.12);
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        gap: 6px;
    }
    .pcard__cta-text {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #6366f1;
        transition: color .15s;
    }
    .dark .pcard__cta-text { color: #a5b4fc; }
    .pcard__cta-arrow {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: rgba(99,102,241,.12);
        display: flex; align-items: center; justify-content: center;
        transition: background .15s, transform .15s;
        flex-shrink: 0;
    }
    .pcard__cta-arrow svg {
        width: 10px; height: 10px;
        stroke: #6366f1;
        transition: stroke .15s;
    }
    .dark .pcard__cta-arrow svg { stroke: #a5b4fc; }
    /* hover lifted from slide, not card, so it fires even mid-3D rotation */
    .proj-slide:hover .pcard__cta-text { color: #4f46e5; }
    .proj-slide:hover .pcard__cta-arrow {
        background: rgba(99,102,241,.22);
        transform: translateX(2px);
    }

    /* ── Dots ───────────────────────────────────────────────────── */
    .proj-dots {
        display: flex;
        justify-content: center;
        gap: 7px;
        padding-bottom: 4px;
    }
    .proj-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: rgba(148,163,184,.3);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: background .2s, transform .2s, width .2s;
    }
    .proj-dot--active {
        background: #6366f1;
        width: 20px;
        border-radius: 99px;
    }
</style>

<div class="proj-outer" id="outer_{{ $uid }}">
    <div class="proj-track" id="track_{{ $uid }}">
        @foreach ($projects as $project)
            <div class="proj-slide">
                <div class="pcard">

                    {{-- Image --}}
                    <div class="pcard__img">
                        <div class="pcard__accent
                            @if ($project->status === 'live') pcard__accent--live
                            @elseif ($project->status === 'wip') pcard__accent--wip
                            @else pcard__accent--dim @endif">
                        </div>

                        @if ($project->thumbnail)
                            <img src="{{ Storage::disk('r2')->url($project->thumbnail) }}"
                                 alt="{{ $project->title }}"
                                 class="pcard__thumb">
                        @else
                            <div class="pcard__placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7l9-4 9 4-9 4-9-4zM3 17l9 4 9-4M3 12l9 4 9-4" />
                                </svg>
                            </div>
                        @endif

                        <div class="pcard__img-fade"></div>

                        @if ($project->status === 'live')
                            <span class="pcard__badge pcard__badge--live">
                                <span class="pcard__dot pcard__dot--pulse"></span>LIVE
                            </span>
                        @elseif ($project->status === 'wip')
                            <span class="pcard__badge pcard__badge--wip">
                                <span class="pcard__dot"></span>WIP
                            </span>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="pcard__body">
                        <a href="{{ route('project.show', $project->slug) }}" class="pcard__title-link">
                            <h3 class="pcard__title">{{ $project->title }}</h3>
                        </a>

                        @if ($project->description)
                            <p class="pcard__desc">{!! $project->description !!}</p>
                        @endif

                        @if ($project->tags && count($project->tags) > 0)
                            <div class="pcard__tags">
                                @foreach (array_slice($project->tags, 0, 3) as $tag)
                                    <span class="pcard__tag">{{ $tag }}</span>
                                @endforeach
                                @if (count($project->tags) > 3)
                                    <span class="pcard__tag pcard__tag--more">+{{ count($project->tags) - 3 }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="pcard__links">
                            @if ($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" onclick="event.stopPropagation()"
                                   class="pcard__link pcard__link--live">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                    Live Demo
                                </a>
                            @endif
                            @if ($project->live_url && $project->repo_url)
                                <span class="pcard__sep">·</span>
                            @endif
                            @if ($project->repo_url)
                                <a href="{{ $project->repo_url }}" target="_blank" onclick="event.stopPropagation()"
                                   class="pcard__link pcard__link--repo">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" />
                                    </svg>
                                    Source
                                </a>
                            @endif
                            @if (!$project->live_url && !$project->repo_url)
                                <span class="pcard__no-links">No links yet</span>
                            @endif
                        </div>

                        {{-- CTA: always at the bottom of the card --}}
                        <a href="{{ route('project.show', $project->slug) }}" class="pcard__cta"
                           onclick="event.stopPropagation()">
                            <span class="pcard__cta-text">View project</span>
                            <span class="pcard__cta-arrow">
                                <svg fill="none" viewBox="0 0 12 12" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 6h8m-3-3 3 3-3 3"/>
                                </svg>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="proj-dots" id="dots_{{ $uid }}"></div>
</div>

<script>
((() => {
    const init = () => {
        const outer  = document.getElementById('outer_{{ $uid }}')
        const track  = document.getElementById('track_{{ $uid }}')
        const dotsEl = document.getElementById('dots_{{ $uid }}')
        if (!track || !outer) return

        // ── Responsive slide width ───────────────────────────────────────
        // Mobile: nearly full viewport width. Desktop: fixed 320px.
        const computeSlideW = () => {
            const vw = window.innerWidth
            if (vw < 480)  return Math.min(vw - 56, 300)   // mobile: leaves ~28px peek each side
            if (vw < 768)  return Math.min(vw - 80, 320)   // large-mobile
            return 320                                        // desktop
        }

        const GAP = 28

        const setSlideW = (w) => {
            track.style.setProperty('--slide-w', w + 'px')
            outer.style.setProperty('--slide-w', w + 'px')
            // update padding so center slide is truly centered
            track.style.paddingLeft  = `calc(50% - ${w / 2}px)`
            track.style.paddingRight = `calc(50% - ${w / 2}px)`
        }

        const origSlides = [...track.querySelectorAll('.proj-slide')]
        const N = origSlides.length
        if (N === 0) return

        if (N === 1) {
            track.style.justifyContent = 'center'
            track.style.paddingLeft = '16px'
            track.style.paddingRight = '16px'
            return
        }

        // ── Clone slides for infinite scroll ────────────────────────────
        const wipe = () => track.querySelectorAll('.proj-slide--clone').forEach(el => el.remove())
        wipe()
        dotsEl.innerHTML = ''

        const cloneSet = (arr) => arr.map(s => {
            const c = s.cloneNode(true)
            c.classList.add('proj-slide--clone')
            return c
        })
        cloneSet(origSlides).forEach(c => track.appendChild(c))
        cloneSet(origSlides).forEach(c => track.prepend(c))

        const allSlides = () => [...track.querySelectorAll('.proj-slide')]

        // ── Dots ─────────────────────────────────────────────────────────
        const dots = origSlides.map((_, i) => {
            const d = document.createElement('button')
            d.className = 'proj-dot'
            d.setAttribute('aria-label', `Go to project ${i + 1}`)
            d.addEventListener('click', () => scrollToIndex(i + N))
            dotsEl.appendChild(d)
            return d
        })

        const getSlideW = () => {
            const first = track.querySelector('.proj-slide')
            return first ? first.offsetWidth + GAP : computeSlideW() + GAP
        }
        const getSetW  = () => N * getSlideW()

        // ── Teleport to middle set without animation ─────────────────────
        const jumpToMiddle = () => { track.scrollLeft = getSetW() }

        setSlideW(computeSlideW())
        requestAnimationFrame(() => {
            jumpToMiddle()
            updateTransforms()
        })

        // ── 3D transform update ──────────────────────────────────────────
        // On mobile (< 480) we skip the 3D effect entirely — it causes
        // bleed + performance issues. A simple opacity fade is enough.
        function updateTransforms() {
            const slides  = allSlides()
            const trackW  = track.offsetWidth
            const centerX = track.scrollLeft + trackW / 2
            const isMobile = window.innerWidth < 480

            slides.forEach(slide => {
                const sc   = slide.offsetLeft + slide.offsetWidth / 2
                const raw  = (sc - centerX) / (trackW * 0.55)
                const clamp = Math.max(-2, Math.min(2, raw))
                const abs  = Math.abs(clamp)

                if (isMobile) {
                    // flat scale + fade only — no rotateY on mobile
                    const scale   = 1 - abs * 0.08
                    const opacity = Math.max(1 - abs * 0.55, 0.2)
                    slide.style.transform = `scale(${scale})`
                    slide.style.opacity   = opacity
                } else {
                    const scale   = 1 - abs * 0.12
                    const opacity = Math.max(1 - abs * 0.5, 0.18)
                    const rotY    = clamp * 18
                    const tz      = -abs * 50
                    slide.style.transform =
                        `perspective(1100px) rotateY(${rotY}deg) scale(${scale}) translateZ(${tz}px)`
                    slide.style.opacity = opacity
                }
                slide.style.zIndex = Math.round((1 - abs) * 20)
            })

            // active dot
            const sw = getSlideW()
            const ci = ((Math.round(track.scrollLeft / sw) % N) + N) % N
            dots.forEach((d, i) => d.classList.toggle('proj-dot--active', i === ci))
        }

        // ── Scroll to index ───────────────────────────────────────────────
        function scrollToIndex(idx) {
            track.scrollTo({ left: idx * getSlideW(), behavior: 'smooth' })
        }

        // ── Infinite-loop teleport ────────────────────────────────────────
        let jumping = false
        track.addEventListener('scroll', () => {
            if (jumping) return
            updateTransforms()
            const sw = getSetW()
            if (track.scrollLeft >= sw * 2) {
                jumping = true; track.scrollLeft -= sw; jumping = false
            } else if (track.scrollLeft < sw) {
                jumping = true; track.scrollLeft += sw; jumping = false
            }
        }, { passive: true })

        // ── Snap on scroll-end ────────────────────────────────────────────
        let snapTimer
        track.addEventListener('scroll', () => {
            clearTimeout(snapTimer)
            snapTimer = setTimeout(() => {
                scrollToIndex(Math.round(track.scrollLeft / getSlideW()))
            }, 80)
        }, { passive: true })

        // ── Mouse drag ────────────────────────────────────────────────────
        let isDragging = false, dragStartX = 0, dragScrollStart = 0
        track.addEventListener('mousedown', e => {
            isDragging = true
            dragStartX = e.pageX
            dragScrollStart = track.scrollLeft
            track.style.cursor = 'grabbing'
            track.style.scrollSnapType = 'none'
            e.preventDefault()
        })
        document.addEventListener('mousemove', e => {
            if (!isDragging) return
            track.scrollLeft = dragScrollStart - (e.pageX - dragStartX)
        })
        document.addEventListener('mouseup', () => {
            if (!isDragging) return
            isDragging = false
            track.style.cursor = 'grab'
            track.style.scrollSnapType = ''
            scrollToIndex(Math.round(track.scrollLeft / getSlideW()))
        })

        // ── Touch drag ────────────────────────────────────────────────────
        let touchStartX = 0, touchScrollStart = 0
        track.addEventListener('touchstart', e => {
            touchStartX = e.touches[0].pageX
            touchScrollStart = track.scrollLeft
        }, { passive: true })
        track.addEventListener('touchmove', e => {
            track.scrollLeft = touchScrollStart - (e.touches[0].pageX - touchStartX)
        }, { passive: true })
        track.addEventListener('touchend', () => {
            scrollToIndex(Math.round(track.scrollLeft / getSlideW()))
        }, { passive: true })

        // ── Autoplay ──────────────────────────────────────────────────────
        let autoTimer
        const startAuto = () => {
            autoTimer = setInterval(() => {
                scrollToIndex(Math.round(track.scrollLeft / getSlideW()) + 1)
            }, 4000)
        }
        const stopAuto = () => clearInterval(autoTimer)

        track.addEventListener('mouseenter', stopAuto)
        track.addEventListener('mouseleave', startAuto)
        track.addEventListener('touchstart', stopAuto, { passive: true })
        startAuto()

        // ── Resize ────────────────────────────────────────────────────────
        let resizeTimer
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer)
            resizeTimer = setTimeout(() => {
                setSlideW(computeSlideW())
                jumpToMiddle()
                updateTransforms()
            }, 120)
        })
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init)
    } else {
        init()
    }
})())
</script>

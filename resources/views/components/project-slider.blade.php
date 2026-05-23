@props(['projects'])
@php $uid = 'pslider_' . uniqid(); @endphp

<style>
/* ── Outer: clips overflowing scaled cards ──────────────────────────── */
.proj-outer {
    position: relative;
    width: 100%;
    overflow: hidden;
}

/* ── Track ───────────────────────────────────────────────────────────── */
.proj-track {
    display: flex;
    align-items: center;
    gap: var(--gap, 20px);
    overflow-x: scroll;
    overflow-y: visible;
    /* ↓ This is the magic: hands touch scrolling fully to the browser */
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    cursor: grab;
    /* vertical padding: room for scale effect + breathing space */
    padding-top: 18px;
    padding-bottom: 22px;
    /* horizontal: computed by JS so first/last slide centers correctly */
    padding-left:  var(--track-px, 16px);
    padding-right: var(--track-px, 16px);
}
.proj-track::-webkit-scrollbar { display: none; }
.proj-track.is-dragging { cursor: grabbing; scroll-snap-type: none; }

/* ── Slide shell ─────────────────────────────────────────────────────── */
.proj-slide {
    flex: 0 0 var(--slide-w, 300px);
    width: var(--slide-w, 300px);
    scroll-snap-align: center;
    scroll-snap-stop: always;   /* one slide per swipe */
    will-change: transform, opacity;
    /* CSS transition so updates from rAF look smooth */
    transition: transform 0.18s ease, opacity 0.18s ease;
}

/* ── Card: fixed height ──────────────────────────────────────────────── */
.pcard {
    background: #ffffff;
    border: 1px solid rgba(148,163,184,0.18);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 400px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s ease;
}
.dark .pcard {
    background: #0f172a;
    border-color: rgba(148,163,184,0.10);
    box-shadow: 0 2px 16px rgba(0,0,0,0.28);
}

/* ── Image zone ──────────────────────────────────────────────────────── */
.pcard__img {
    position: relative;
    height: 168px;
    flex-shrink: 0;
    overflow: hidden;
    background: #0f172a;
}
.pcard__thumb {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
}
.pcard__placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: rgba(148,163,184,0.3);
    background: linear-gradient(135deg,#0f172a,#1e293b);
}
.pcard__img-fade {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 48px;
    background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.4));
    pointer-events: none;
}

/* accent strip */
.pcard__accent {
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px; z-index: 2;
}
.pcard__accent--live { background: linear-gradient(90deg,#22d3ee,#6366f1); }
.pcard__accent--wip  { background: linear-gradient(90deg,#f59e0b,#ef4444); }
.pcard__accent--dim  { background: rgba(148,163,184,0.18); }

/* ── Title row: title + badge side by side ───────────────────────────── */
.pcard__title-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    flex-shrink: 0;
    min-width: 0;
}
.pcard__title-link { text-decoration: none; display: block; min-width: 0; flex: 1 1 0; }
.pcard__title {
    font-size: 15px; font-weight: 700; line-height: 1.3;
    color: #0f172a; margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.dark .pcard__title { color: #f1f5f9; }

/* ── LIVE / WIP badge — inline in body ───────────────────────────────── */
.pcard__badge {
    display: inline-flex; align-items: center; gap: 5px;
    flex-shrink: 0;
    font-size: 9px; font-weight: 800; letter-spacing: .13em;
    padding: 3px 7px 3px 6px; border-radius: 99px;
    white-space: nowrap;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
}
.pcard__badge--live {
    background: linear-gradient(90deg, rgba(6,182,212,0.15) 0%, rgba(99,102,241,0.18) 100%);
    color: #06b6d4;
    box-shadow: 0 0 0 1px rgba(6,182,212,0.3), 0 0 8px rgba(6,182,212,0.15);
}
.dark .pcard__badge--live {
    background: linear-gradient(90deg, rgba(6,182,212,0.2) 0%, rgba(99,102,241,0.22) 100%);
    color: #22d3ee;
    box-shadow: 0 0 0 1px rgba(34,211,238,0.35), 0 0 10px rgba(34,211,238,0.18);
}
.pcard__badge--wip {
    background: rgba(245,158,11,.1);
    color: #d97706;
    box-shadow: 0 0 0 1px rgba(245,158,11,.28);
}
.dark .pcard__badge--wip {
    background: rgba(245,158,11,.14);
    color: #fbbf24;
    box-shadow: 0 0 0 1px rgba(251,191,36,.32);
}

/* ping dot wrapper */
.pcard__dot-wrap {
    position: relative; width: 7px; height: 7px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pcard__dot-wrap::before {
    content: '';
    position: absolute; inset: -2px; border-radius: 50%;
    background: currentColor; opacity: 0.5;
    animation: liveping 1.8s ease-out infinite;
}
@keyframes liveping {
    0%   { transform: scale(0.6); opacity: .6; }
    80%  { transform: scale(2.4); opacity: 0; }
    100% { transform: scale(2.4); opacity: 0; }
}
.pcard__dot {
    width: 6px; height: 6px; border-radius: 50%;
    display: block; flex-shrink: 0; background: currentColor;
}

/* ── Body ────────────────────────────────────────────────────────────── */
.pcard__body {
    flex: 1 1 0;
    min-height: 0;
    display: flex; flex-direction: column;
    padding: 14px 16px 14px;
    overflow: hidden;
}
.pcard__title-link { text-decoration: none; display: block; flex-shrink: 0; }
.pcard__title {
    font-size: 15px; font-weight: 700; line-height: 1.3;
    color: #0f172a; margin: 0 0 6px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.dark .pcard__title { color: #f1f5f9; }

/* description: 3-line clamp */
.pcard__desc {
    font-size: 13px; line-height: 1.55; color: #64748b;
    margin: 0 0 10px; flex-shrink: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.dark .pcard__desc { color: #94a3b8; }

/* tags */
.pcard__tags { display:flex; flex-wrap:wrap; gap:5px; margin-bottom:10px; flex-shrink:0; }
.pcard__tag {
    font-size: 10px; font-weight: 600; letter-spacing:.05em;
    padding: 2px 8px; border-radius: 99px;
    background: rgba(99,102,241,.1); color: #6366f1; border: 1px solid rgba(99,102,241,.18);
}
.dark .pcard__tag { background:rgba(99,102,241,.15); color:#a5b4fc; border-color:rgba(99,102,241,.22); }
.pcard__tag--more { background:rgba(148,163,184,.1); color:#64748b; border-color:rgba(148,163,184,.18); }

/* links */
.pcard__links { display:flex; align-items:center; gap:8px; flex-shrink:0; }
.pcard__link {
    display:inline-flex; align-items:center; gap:4px;
    font-size:11px; font-weight:600; text-decoration:none;
    padding:3px 0; transition:opacity .15s;
}
.pcard__link:hover { opacity:.65; }
.pcard__link--live { color:#22d3ee; }
.pcard__link--repo { color:#94a3b8; }
.pcard__sep  { color:rgba(148,163,184,.4); font-size:14px; }
.pcard__no-links { font-size:11px; color:rgba(148,163,184,.45); }

/* ── CTA — pinned to card bottom ─────────────────────────────────────── */
.pcard__cta {
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid rgba(148,163,184,.12);
    display: flex; align-items: center; justify-content: space-between;
    text-decoration: none;
}
.pcard__cta-label {
    font-size: 11px; font-weight: 600; letter-spacing: .07em;
    text-transform: uppercase; color: #6366f1;
    transition: color .15s;
}
.dark .pcard__cta-label { color: #a5b4fc; }
.pcard__cta-arrow {
    width: 22px; height: 22px; border-radius: 50%;
    background: rgba(99,102,241,.1);
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, transform .18s;
}
.pcard__cta-arrow svg { width:10px; height:10px; stroke:#6366f1; }
.dark .pcard__cta-arrow svg { stroke:#a5b4fc; }
.pcard:hover .pcard__cta-label { color: #4f46e5; }
.pcard:hover .pcard__cta-arrow { background:rgba(99,102,241,.2); transform:translateX(3px); }

/* ── Dots ────────────────────────────────────────────────────────────── */
.proj-dots { display:flex; justify-content:center; gap:7px; padding-bottom:2px; }
.proj-dot {
    width:6px; height:6px; border-radius:99px;
    background:rgba(148,163,184,.3); border:none; padding:0; cursor:pointer;
    transition: background .22s, width .22s;
}
.proj-dot--active { background:#6366f1; width:20px; }
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
                                 alt="{{ $project->title }}" class="pcard__thumb">
                        @else
                            <div class="pcard__placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                     fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 7l9-4 9 4-9 4-9-4zM3 17l9 4 9-4M3 12l9 4 9-4"/>
                                </svg>
                            </div>
                        @endif

                        <div class="pcard__img-fade"></div>
                    </div>

                    {{-- Body --}}
                    <div class="pcard__body">
                        <div class="pcard__title-row">
                            <a href="{{ route('project.show', $project->slug) }}" class="pcard__title-link">
                                <h3 class="pcard__title">{{ $project->title }}</h3>
                            </a>
                            @if ($project->status === 'live')
                                <span class="pcard__badge pcard__badge--live">
                                    <span class="pcard__dot-wrap"><span class="pcard__dot"></span></span>LIVE
                                </span>
                            @elseif ($project->status === 'wip')
                                <span class="pcard__badge pcard__badge--wip">
                                    <span class="pcard__dot"></span>WIP
                                </span>
                            @endif
                        </div>

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
                                <a href="{{ $project->live_url }}" target="_blank"
                                   onclick="event.stopPropagation()"
                                   class="pcard__link pcard__link--live">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                    </svg>
                                    Live Demo
                                </a>
                            @endif
                            @if ($project->live_url && $project->repo_url)
                                <span class="pcard__sep">·</span>
                            @endif
                            @if ($project->repo_url)
                                <a href="{{ $project->repo_url }}" target="_blank"
                                   onclick="event.stopPropagation()"
                                   class="pcard__link pcard__link--repo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/>
                                    </svg>
                                    Source
                                </a>
                            @endif
                            @if (!$project->live_url && !$project->repo_url)
                                <span class="pcard__no-links">No links yet</span>
                            @endif
                        </div>

                        <a href="{{ route('project.show', $project->slug) }}" class="pcard__cta"
                           onclick="event.stopPropagation()">
                            <span class="pcard__cta-label">View project</span>
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
(function () {
    function init() {
        var track  = document.getElementById('track_{{ $uid }}')
        var dotsEl = document.getElementById('dots_{{ $uid }}')
        if (!track) return

        var orig = Array.prototype.slice.call(track.querySelectorAll('.proj-slide'))
        var N = orig.length
        if (N === 0) return

        var GAP = 20

        /* ── Responsive slide width ───────────────────────────────────── */
        function computeW() {
            var vw = window.innerWidth
            if (vw < 480) return Math.min(vw - 60, 290)   // ~30px peek each side
            if (vw < 768) return Math.min(vw - 80, 320)
            return 320
        }

        function applyW(w) {
            track.style.setProperty('--slide-w', w + 'px')
            // center-align first/last slide
            var px = Math.max(16, Math.round((track.offsetWidth - w) / 2))
            track.style.setProperty('--track-px', px + 'px')
            track.style.paddingLeft  = px + 'px'
            track.style.paddingRight = px + 'px'
        }

        /* ── Build clones for infinite loop ──────────────────────────── */
        function buildClones() {
            track.querySelectorAll('.proj-slide--c').forEach(function (el) { el.remove() })
            dotsEl.innerHTML = ''
            orig.forEach(function (s) {
                var c = s.cloneNode(true); c.classList.add('proj-slide--c')
                track.appendChild(c)
            })
            orig.forEach(function (s) {
                var c = s.cloneNode(true); c.classList.add('proj-slide--c')
                track.prepend(c)
            })
        }

        buildClones()

        /* ── Dots ─────────────────────────────────────────────────────── */
        var dots = orig.map(function (_, i) {
            var d = document.createElement('button')
            d.className = 'proj-dot'
            d.setAttribute('aria-label', 'Project ' + (i + 1))
            d.addEventListener('click', function () { goTo(i + N, true) })
            dotsEl.appendChild(d)
            return d
        })

        /* ── Metrics ──────────────────────────────────────────────────── */
        function stepW()  { return parseFloat(track.style.getPropertyValue('--slide-w') || computeW()) + GAP }
        function setW()   { return N * stepW() }

        /* ── Jump to middle set (no animation) ────────────────────────── */
        function jumpMiddle() { track.scrollLeft = setW() }

        applyW(computeW())
        requestAnimationFrame(jumpMiddle)

        /* ── Navigate ─────────────────────────────────────────────────── */
        function goTo(idx, smooth) {
            track.scrollTo({ left: idx * stepW(), behavior: smooth ? 'smooth' : 'auto' })
        }

        /* ── Update dots + scale/opacity ──────────────────────────────── */
        var rafId = null
        function update() {
            rafId = null
            var slides   = track.querySelectorAll('.proj-slide')
            var trackW   = track.offsetWidth
            var centerX  = track.scrollLeft + trackW / 2
            var sw       = stepW()
            var mobile   = window.innerWidth < 600

            for (var i = 0; i < slides.length; i++) {
                var sl  = slides[i]
                var sc  = sl.offsetLeft + sl.offsetWidth / 2
                var raw = (sc - centerX) / (trackW * 0.55)
                var cl  = Math.max(-2, Math.min(2, raw))
                var abs = Math.abs(cl)

                if (mobile) {
                    /* mobile: flat scale + opacity only — no 3-D, no overflow risk */
                    var s = 1 - abs * 0.07
                    var o = Math.max(1 - abs * 0.5, 0.22)
                    sl.style.transform = 'scale(' + s + ')'
                    sl.style.opacity   = o
                } else {
                    /* desktop: subtle rotateY */
                    var s2 = 1 - abs * 0.11
                    var o2 = Math.max(1 - abs * 0.48, 0.18)
                    var ry = cl * 16
                    var tz = -abs * 42
                    sl.style.transform = 'perspective(900px) rotateY(' + ry + 'deg) scale(' + s2 + ') translateZ(' + tz + 'px)'
                    sl.style.opacity   = o2
                }
                sl.style.zIndex = Math.round((1 - abs) * 10)
            }

            /* active dot */
            var ci = (((Math.round(track.scrollLeft / sw)) % N) + N) % N
            dots.forEach(function (d, i) { d.classList.toggle('proj-dot--active', i === ci) })
        }

        function scheduleUpdate() {
            if (!rafId) rafId = requestAnimationFrame(update)
        }

        /* ── Infinite teleport — fires AFTER scroll settles ────────────── */
        var teleporting = false
        function teleport() {
            if (teleporting) return
            var sw = setW()
            if (track.scrollLeft >= sw * 2) {
                teleporting = true; track.scrollLeft -= sw; teleporting = false
            } else if (track.scrollLeft < sw) {
                teleporting = true; track.scrollLeft += sw; teleporting = false
            }
        }

        /* scrollend fires after momentum stops — perfect for teleport */
        var snapTimer
        function onScrollEnd() {
            teleport()
            /* also snap to nearest in case scroll-snap drifted slightly */
            goTo(Math.round(track.scrollLeft / stepW()), true)
        }

        track.addEventListener('scroll', scheduleUpdate, { passive: true })

        if ('onscrollend' in window) {
            track.addEventListener('scrollend', onScrollEnd)
        } else {
            /* fallback for Safari < 17.4 */
            track.addEventListener('scroll', function () {
                clearTimeout(snapTimer)
                snapTimer = setTimeout(onScrollEnd, 110)
            }, { passive: true })
        }

        /* ── Desktop mouse drag ───────────────────────────────────────── */
        var dragging = false, dStartX = 0, dStartScroll = 0

        track.addEventListener('mousedown', function (e) {
            dragging = true
            dStartX      = e.pageX
            dStartScroll = track.scrollLeft
            track.classList.add('is-dragging')
            e.preventDefault()
        })
        document.addEventListener('mousemove', function (e) {
            if (!dragging) return
            track.scrollLeft = dStartScroll - (e.pageX - dStartX)
        })
        document.addEventListener('mouseup', function () {
            if (!dragging) return
            dragging = false
            track.classList.remove('is-dragging')
            goTo(Math.round(track.scrollLeft / stepW()), true)
        })

        /* ── Autoplay ─────────────────────────────────────────────────── */
        var auto
        function startAuto() {
            auto = setInterval(function () {
                goTo(Math.round(track.scrollLeft / stepW()) + 1, true)
            }, 4000)
        }
        function stopAuto() { clearInterval(auto) }

        track.addEventListener('mouseenter',  stopAuto)
        track.addEventListener('mouseleave',  startAuto)
        track.addEventListener('touchstart',  stopAuto,  { passive: true })
        track.addEventListener('touchend',    startAuto, { passive: true })
        startAuto()

        /* ── Resize ───────────────────────────────────────────────────── */
        var resizeT
        window.addEventListener('resize', function () {
            clearTimeout(resizeT)
            resizeT = setTimeout(function () {
                applyW(computeW())
                jumpMiddle()
                scheduleUpdate()
            }, 150)
        })
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init)
    } else {
        init()
    }
}())
</script>

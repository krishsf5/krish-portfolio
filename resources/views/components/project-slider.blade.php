@props(['projects'])

@php $uid = 'pslider_' . uniqid(); @endphp

<div class="proj-outer" id="outer_{{ $uid }}">
    <div class="proj-track" id="track_{{ $uid }}">
        @foreach ($projects as $project)
            <div class="proj-slide">
                <div class="pcard">

                    {{-- Image --}}
                    <div class="pcard__img">
                        <div
                            class="pcard__accent
                            @if ($project->status === 'live') pcard__accent--live
                            @elseif ($project->status === 'wip') pcard__accent--wip
                            @else                                pcard__accent--dim @endif">
                        </div>

                        @if ($project->thumbnail)
                            <img src="{{ Storage::disk('r2')->url($project->thumbnail) }}" alt="{{ $project->title }}"
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
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" />
                                    </svg>
                                    Source
                                </a>
                            @endif
                            @if (!$project->live_url && !$project->repo_url)
                                <span class="pcard__no-links">No links yet</span>
                            @endif
                        </div>
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
            const track = document.getElementById('track_{{ $uid }}')
            const dotsContainer = document.getElementById('dots_{{ $uid }}')
            if (!track) return

            const origSlides = [...track.querySelectorAll('.proj-slide')]
            const N = origSlides.length
            if (N === 0) return

            if (N === 1) {
                track.style.justifyContent = 'center'
                return
            }

            // Wipe any previous clones (safe for Livewire re-renders)
            track.querySelectorAll('.proj-slide--clone').forEach(el => el.remove())
            dotsContainer.innerHTML = ''

            // Clone for infinite scroll: prepend + append one full set each
            const appendClones = origSlides.map(s => {
                const c = s.cloneNode(true)
                c.classList.add('proj-slide--clone')
                return c
            })
            const prependClones = origSlides.map(s => {
                const c = s.cloneNode(true)
                c.classList.add('proj-slide--clone')
                return c
            })
            appendClones.forEach(c => track.appendChild(c))
            prependClones.forEach(c => track.prepend(c))

            const allSlides = [...track.querySelectorAll('.proj-slide')]

            // Dots
            const dots = origSlides.map((_, i) => {
                const d = document.createElement('button')
                d.className = 'proj-dot'
                d.setAttribute('aria-label', `Go to project ${i + 1}`)
                d.addEventListener('click', () => scrollToIndex(i + N))
                dotsContainer.appendChild(d)
                return d
            })

            const GAP = 28
            const getSlideW = () => allSlides[0].offsetWidth + GAP
            const getSetW = () => N * getSlideW()

            // Jump to middle set without animation
            track.scrollLeft = getSetW()
            update()

            function update() {
                const trackW = track.offsetWidth
                const centerX = track.scrollLeft + trackW / 2

                allSlides.forEach(slide => {
                    const sc = slide.offsetLeft + slide.offsetWidth / 2
                    const raw = (sc - centerX) / (trackW * 0.5)
                    const clamped = Math.max(-2, Math.min(2, raw))
                    const abs = Math.abs(clamped)
                    const scale = 1 - abs * 0.12
                    const opacity = Math.max(1 - abs * 0.5, 0.18)
                    const rotY = clamped * 22
                    const tz = -abs * 55
                    slide.style.transform =
                        `perspective(1100px) rotateY(${rotY}deg) scale(${scale}) translateZ(${tz}px)`
                    slide.style.opacity = opacity
                    slide.style.zIndex = Math.round((1 - abs) * 20)
                })

                const ci = ((Math.round(track.scrollLeft / getSlideW()) % N) + N) % N
                dots.forEach((d, i) => d.classList.toggle('proj-dot--active', i === ci))
            }

            function scrollToIndex(idx) {
                track.scrollTo({
                    left: idx * getSlideW(),
                    behavior: 'smooth'
                })
            }

            // Infinite loop teleport
            let jumping = false
            track.addEventListener('scroll', () => {
                if (jumping) return
                update()
                const sw = getSetW()
                if (track.scrollLeft >= sw * 2) {
                    jumping = true;
                    track.scrollLeft -= sw;
                    jumping = false
                } else if (track.scrollLeft < sw) {
                    jumping = true;
                    track.scrollLeft += sw;
                    jumping = false
                }
            }, {
                passive: true
            })

            // Snap on scroll end
            let snapTimer
            track.addEventListener('scroll', () => {
                clearTimeout(snapTimer)
                snapTimer = setTimeout(() => {
                    scrollToIndex(Math.round(track.scrollLeft / getSlideW()))
                }, 80)
            }, {
                passive: true
            })

            // Mouse drag
            let isDragging = false,
                dragStartX = 0,
                dragScrollStart = 0

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

            // Touch drag
            let touchStartX = 0,
                touchScrollStart = 0
            track.addEventListener('touchstart', e => {
                touchStartX = e.touches[0].pageX
                touchScrollStart = track.scrollLeft
            }, {
                passive: true
            })
            track.addEventListener('touchmove', e => {
                track.scrollLeft = touchScrollStart - (e.touches[0].pageX - touchStartX)
            }, {
                passive: true
            })
            track.addEventListener('touchend', () => {
                scrollToIndex(Math.round(track.scrollLeft / getSlideW()))
            }, {
                passive: true
            })

            // Autoplay
            let autoTimer
            const startAuto = () => {
                autoTimer = setInterval(() => {
                    scrollToIndex(Math.round(track.scrollLeft / getSlideW()) + 1)
                }, 4000)
            }
            const stopAuto = () => clearInterval(autoTimer)

            track.addEventListener('mouseenter', stopAuto)
            track.addEventListener('mouseleave', startAuto)
            track.addEventListener('touchstart', stopAuto, {
                passive: true
            })

            startAuto()
            window.addEventListener('resize', () => {
                track.scrollLeft = getSetW()
                update()
            })
        }

        // Run after DOM is ready — handles both normal page load and Livewire navigation
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init)
        } else {
            init()
        }
    })())
</script>

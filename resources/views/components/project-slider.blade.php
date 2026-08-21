@props(['projects'])
@php $uid = 'pslider_' . uniqid(); @endphp

{{-- Swiper CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
/* ── Swiper overrides ────────────────────────────────────────────────── */
#swiper_{{ $uid }} {
    width: 100%;
    padding: 16px 0 12px !important;
    /* let scaled side-cards breathe without page overflow */
    overflow: visible !important;
}
/* clip overflow at the section level */
.proj-outer {
    width: 100%;
    overflow: hidden;
    position: relative;
}

/* slide width: responsive via CSS only — no JS needed */
#swiper_{{ $uid }} .swiper-slide {
    width: 380px;
}
@media (max-width: 767px) {
    #swiper_{{ $uid }} .swiper-slide {
        width: calc(100vw - 48px); /* ~24px peek on each side */
    }
}
@media (min-width: 768px) and (max-width: 1023px) {
    #swiper_{{ $uid }} .swiper-slide {
        width: 350px;
    }
}

/* adjacent slide effect — CSS-only, no JS transforms */
#swiper_{{ $uid }} .swiper-slide {
    transition: transform 0.35s ease, opacity 0.35s ease;
    transform: scale(0.93);
    opacity: 0.55;
}
#swiper_{{ $uid }} .swiper-slide-active {
    transform: scale(1);
    opacity: 1;
}
#swiper_{{ $uid }} .swiper-slide-prev,
#swiper_{{ $uid }} .swiper-slide-next {
    transform: scale(0.96);
    opacity: 0.75;
}

/* ── Pagination dots ─────────────────────────────────────────────────── */
.proj-pagination {
    display: flex;
    justify-content: center;
    gap: 7px;
    padding: 10px 0 4px;
}
/* Swiper injects .proj-dot via bulletClass */
.proj-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 9999px;
    background: rgba(148, 163, 184, 0.35);
    cursor: pointer;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                background-color 0.3s ease;
}
.proj-dot--active {
    width: 22px;
    background: #6366f1;
}
.dark .proj-dot--active {
    background: #22d3ee;
}

/* ── Compact Card ─────────────────────────────────────────────────────── */
.pcard {
    background: #ffffff;
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 440px;
    user-select: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.dark .pcard {
    background: #0d121f;
    border-color: rgba(148, 163, 184, 0.1);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
}
.swiper-slide-active .pcard {
    border-color: rgba(99, 102, 241, 0.35);
    box-shadow: 0 8px 24px -4px rgba(99, 102, 241, 0.12);
}
.dark .swiper-slide-active .pcard {
    border-color: rgba(34, 211, 238, 0.3);
    box-shadow: 0 8px 24px -4px rgba(34, 211, 238, 0.08);
}

/* Image area — prominent 190px */
.pcard__img {
    height: 190px;
    position: relative;
    overflow: hidden;
    background: #f1f5f9;
    flex-shrink: 0;
}
.dark .pcard__img {
    background: #080c14;
}
.pcard__thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}
.pcard:hover .pcard__thumb {
    transform: scale(1.04);
}
.pcard__placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(148, 163, 184, 0.3);
}

/* Gradient line top of card */
.pcard__accent {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    z-index: 2;
}
.pcard__accent--live {
    background: linear-gradient(90deg, #10b981, #22d3ee);
}
.pcard__accent--wip {
    background: linear-gradient(90deg, #f59e0b, #ef4444);
}
.pcard__accent--dim {
    background: linear-gradient(90deg, #6366f1, #a855f7);
}

/* Fade at bottom of image */
.pcard__img-fade {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 32px;
    background: linear-gradient(to top, #ffffff, transparent);
    pointer-events: none;
}
.dark .pcard__img-fade {
    background: linear-gradient(to top, #0d121f, transparent);
}

/* Card Body */
.pcard__body {
    padding: 16px 18px 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: hidden;
}

/* Title row: title left, badge right */
.pcard__title-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 8px;
}
.pcard__title-link {
    text-decoration: none;
    flex: 1;
    min-width: 0;
    position: relative;
    z-index: 10;
    cursor: pointer;
    display: block;
}
.pcard__title {
    font-size: 15.5px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.15s;
    cursor: pointer;
}
.dark .pcard__title { color: #f1f5f9; }
.pcard:hover .pcard__title { color: #6366f1; }
.dark .pcard:hover .pcard__title { color: #22d3ee; }

/* Status badge */
.pcard__badge {
    display: inline-flex;
    align-items: center;
    gap: 3.5px;
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: .06em;
    font-family: 'DM Mono', monospace;
    padding: 2px 6px;
    border-radius: 4px;
    flex-shrink: 0;
    line-height: 1.2;
}
.pcard__badge--live {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.25);
}
.dark .pcard__badge--live {
    background: rgba(16, 185, 129, 0.12);
    color: #34d399;
}
.pcard__badge--wip {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.25);
}
.dark .pcard__badge--wip {
    background: rgba(245, 158, 11, 0.12);
    color: #fbbf24;
}
.pcard__dot-wrap { position: relative; display: inline-flex; width: 5px; height: 5px; }
.pcard__dot {
    width: 5px; height: 5px; border-radius: 50%;
    background: currentColor; display: block;
}
.pcard__dot--pulse {
    position: absolute; inset: 0; border-radius: 50%;
    background: currentColor; opacity: .75;
    animation: pcard-ping 1.5s cubic-bezier(0,0,.2,1) infinite;
}
@keyframes pcard-ping {
    75%, 100% { transform: scale(2.2); opacity: 0; }
}

/* Description — 2-line clamp */
.pcard__desc {
    font-size: 11.5px;
    line-height: 1.45;
    color: #64748b;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.dark .pcard__desc { color: #94a3b8; }
.pcard__readmore {
    color: #6366f1;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
}
.dark .pcard__readmore { color: #22d3ee; }

/* Tags — horizontal scroll / wrap */
.pcard__tags {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 8px;
}
.pcard__tag {
    font-size: 10px;
    font-family: 'DM Mono', monospace;
    font-weight: 500;
    padding: 2px 6.5px;
    border-radius: 4px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid rgba(148, 163, 184, 0.25);
    white-space: nowrap;
}
.dark .pcard__tag {
    background: rgba(15, 23, 42, 0.8);
    color: #94a3b8;
    border-color: rgba(148, 163, 184, 0.12);
}
.pcard__tag--more {
    background: transparent;
    border-color: transparent;
    color: #94a3b8;
    padding: 2px 2px;
}

/* Links row */
.pcard__links {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: auto;
    padding-top: 6px;
}
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

/* CTA pinned to bottom */
.pcard__cta {
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid rgba(148,163,184,.12);
    display: flex; align-items: center; justify-content: space-between;
    text-decoration: none;
}
.pcard__cta-label {
    font-size: 11px; font-weight: 600; letter-spacing: .07em;
    text-transform: uppercase; color: #6366f1; transition: color .15s;
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
</style>

<div class="proj-outer">
    <div class="swiper" id="swiper_{{ $uid }}">
        <div class="swiper-wrapper">
            @foreach ($projects as $project)
                <div class="swiper-slide">
                    <div class="pcard">

                        @php
                            $mediaList = [];
                            if (is_array($project->media ?? null) && count($project->media) > 0) {
                                $mediaList = $project->media;
                            } elseif (!empty($project->thumbnail)) {
                                $mediaList = [['type' => 'image', 'url' => $project->thumbnail]];
                            }
                            $hasMulti = count($mediaList) > 1;
                        @endphp

                        {{-- Media Area with Micro-Slideshow --}}
                        <div class="pcard__img relative overflow-hidden"
                            @if($hasMulti)
                                x-data="{
                                    active: 0,
                                    total: {{ count($mediaList) }},
                                    interval: null,
                                    start() {
                                        this.interval = setInterval(() => {
                                            this.active = (this.active + 1) % this.total;
                                        }, 3500);
                                    },
                                    stop() {
                                        if (this.interval) {
                                            clearInterval(this.interval);
                                            this.interval = null;
                                        }
                                    }
                                }"
                                x-init="start()"
                                @mouseenter="stop()"
                                @mouseleave="start()"
                            @endif
                        >
                            <a href="{{ route('project.show', $project->slug) }}" wire:navigate class="block w-full h-full relative z-10">
                                <div class="pcard__accent
                                    @if ($project->status === 'live') pcard__accent--live
                                    @elseif ($project->status === 'wip') pcard__accent--wip
                                    @else pcard__accent--dim @endif">
                                </div>

                                @if (!empty($mediaList))
                                    @foreach ($mediaList as $mIdx => $mItem)
                                        @php
                                            $mType = $mItem['type'] ?? 'image';
                                            $mPath = is_array($mItem) ? ($mItem['url'] ?? '') : ($mItem->url ?? '');
                                            $isVid = $mType === 'video' || str_ends_with(strtolower($mPath), '.mp4') || str_ends_with(strtolower($mPath), '.webm');
                                            $fullUrl = Storage::disk('r2')->url($mPath);
                                        @endphp
                                        <div class="absolute inset-0 transition-opacity duration-700 ease-in-out w-full h-full"
                                            @if($hasMulti)
                                                :class="active === {{ $mIdx }} ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
                                            @endif
                                        >
                                            @if($isVid)
                                                <video src="{{ $fullUrl }}" class="w-full h-full object-cover" autoplay muted loop playsinline></video>
                                                <div class="absolute top-2.5 right-2.5 bg-black/70 backdrop-blur-sm px-2 py-0.5 rounded-md flex items-center gap-1 text-[9.5px] font-mono font-bold text-cyan-300 z-20">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-cyan-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6.3 2.841A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.269l9.344-5.89a1.5 1.5 0 0 0 0-2.538L6.3 2.84z" />
                                                    </svg>
                                                    VIDEO
                                                </div>
                                            @else
                                                <img src="{{ $fullUrl }}" alt="{{ $project->title }}" class="pcard__thumb">
                                            @endif
                                        </div>
                                    @endforeach
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
                            </a>

                            {{-- In-Card Slideshow Dot Indicators --}}
                            @if($hasMulti)
                                <div class="absolute bottom-2.5 right-3 z-20 flex items-center gap-1.5 bg-black/60 backdrop-blur-md px-2 py-0.5 rounded-full pointer-events-none">
                                    <span class="text-[9.5px] font-mono font-bold text-white/90">
                                        <span x-text="active + 1"></span>/{{ count($mediaList) }}
                                    </span>
                                    <div class="flex items-center gap-1 ml-0.5">
                                        @foreach($mediaList as $dotIdx => $dotItem)
                                            <span class="inline-block h-1 rounded-full transition-all duration-300"
                                                :class="active === {{ $dotIdx }} ? 'w-3 bg-cyan-400' : 'w-1 bg-white/40'"></span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="pcard__body">

                            <div class="pcard__title-row">
                                <a href="{{ route('project.show', $project->slug) }}" wire:navigate class="pcard__title-link">
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
                                @php
                                    $plain   = strip_tags($project->description);
                                    $words   = str_word_count($plain, 1);
                                    $count   = count($words);
                                    $limit   = 20;
                                    $trimmed = $count > $limit
                                        ? implode(' ', array_slice($words, 0, $limit))
                                        : $plain;
                                    $needsMore = $count > $limit;
                                @endphp
                                <p class="pcard__desc">
                                    {{ $trimmed }}{{ $needsMore ? '...' : '' }}
                                    @if ($needsMore)
                                        &ensp;<a href="{{ route('project.show', $project->slug) }}" wire:navigate
                                               class="pcard__readmore">Read more</a>
                                    @endif
                                </p>
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

                            <a href="{{ route('project.show', $project->slug) }}" wire:navigate class="pcard__cta">
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

        {{-- Pagination dots --}}
        <div class="proj-pagination" id="dots_{{ $uid }}"></div>
    </div>
</div>

{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function () {
    let swiperInstance = null;

    function init() {
        if (typeof Swiper === 'undefined') {
            setTimeout(init, 50);
            return;
        }

        const el = document.querySelector('#swiper_{{ $uid }}');
        if (!el) return;

        if (swiperInstance) {
            try { swiperInstance.destroy(true, true); } catch(e) {}
        }

        const slideCount = el.querySelectorAll('.swiper-slide').length;

        swiperInstance = new Swiper('#swiper_{{ $uid }}', {
            slidesPerView:  'auto',
            centeredSlides: true,
            spaceBetween:   20,
            loop:           false,
            grabCursor:     true,
            speed:          420,
            threshold:      10,
            touchStartPreventDefault: false,
            preventClicks:  false,
            preventClicksPropagation: false,

            autoplay: slideCount > 1 ? {
                delay:                  4000,
                disableOnInteraction:   false,
                pauseOnMouseEnter:      true,
            } : false,

            pagination: {
                el:              '#dots_{{ $uid }}',
                clickable:       true,
                bulletClass:     'proj-dot',
                bulletActiveClass: 'proj-dot--active',
            },
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    document.addEventListener('livewire:navigated', init);
})();
</script>

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
    width: 300px;
}
@media (max-width: 767px) {
    #swiper_{{ $uid }} .swiper-slide {
        width: calc(100vw - 56px); /* ~28px peek on each side */
    }
}
@media (min-width: 768px) and (max-width: 1023px) {
    #swiper_{{ $uid }} .swiper-slide {
        width: 310px;
    }
}

/* adjacent slide effect — CSS-only, no JS transforms */
#swiper_{{ $uid }} .swiper-slide {
    transition: transform 0.35s ease, opacity 0.35s ease;
    transform: scale(0.91);
    opacity: 0.45;
}
#swiper_{{ $uid }} .swiper-slide-active {
    transform: scale(1);
    opacity: 1;
}
#swiper_{{ $uid }} .swiper-slide-prev,
#swiper_{{ $uid }} .swiper-slide-next {
    transform: scale(0.95);
    opacity: 0.7;
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
    width: 6px; height: 6px;
    border-radius: 99px;
    background: rgba(148,163,184,.3);
    border: none; padding: 0; cursor: pointer;
    transition: background .22s, width .22s;
    opacity: 1 !important; /* override Swiper default */
}
.proj-dot.proj-dot--active {
    background: #6366f1;
    width: 20px;
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

/* ── Body ────────────────────────────────────────────────────────────── */
.pcard__body {
    flex: 1 1 0;
    min-height: 0;
    display: flex; flex-direction: column;
    padding: 14px 16px;
    overflow: hidden;
}

/* title row: title + badge */
.pcard__title-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    flex-shrink: 0;
    min-width: 0;
}
.pcard__title-link {
    text-decoration: none; display: block;
    min-width: 0; flex: 1 1 0;
}
.pcard__title {
    font-size: 15px; font-weight: 700; line-height: 1.3;
    color: #0f172a; margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    text-decoration: underline;
    text-underline-offset: 3px;
    text-decoration-thickness: 1px;
    text-decoration-color: rgba(15,23,42,0.25);
    transition: color .15s, text-decoration-color .15s;
}
.pcard__title-link:hover .pcard__title {
    color: #4f46e5;
    text-decoration-color: rgba(79,70,229,0.5);
}
.dark .pcard__title { color: #f1f5f9; text-decoration-color: rgba(241,245,249,0.22); }
.dark .pcard__title-link:hover .pcard__title { color: #a5b4fc; text-decoration-color: rgba(165,180,252,0.45); }

/* ── LIVE / WIP badge ────────────────────────────────────────────────── */
.pcard__badge {
    display: inline-flex; align-items: center; gap: 5px;
    flex-shrink: 0;
    font-size: 9px; font-weight: 800; letter-spacing: .13em;
    padding: 3px 7px 3px 6px; border-radius: 99px;
    white-space: nowrap;
}
.pcard__badge--live {
    background: linear-gradient(90deg, rgba(6,182,212,0.12), rgba(99,102,241,0.15));
    color: #06b6d4;
    box-shadow: 0 0 0 1px rgba(6,182,212,0.28), 0 0 7px rgba(6,182,212,0.12);
}
.dark .pcard__badge--live {
    background: linear-gradient(90deg, rgba(6,182,212,0.18), rgba(99,102,241,0.2));
    color: #22d3ee;
    box-shadow: 0 0 0 1px rgba(34,211,238,0.32), 0 0 9px rgba(34,211,238,0.16);
}
.pcard__badge--wip {
    background: rgba(245,158,11,.1);
    color: #d97706;
    box-shadow: 0 0 0 1px rgba(245,158,11,.26);
}
.dark .pcard__badge--wip {
    background: rgba(245,158,11,.13);
    color: #fbbf24;
    box-shadow: 0 0 0 1px rgba(251,191,36,.3);
}
/* ping dot */
.pcard__dot-wrap {
    position: relative; width: 7px; height: 7px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pcard__dot-wrap::before {
    content: '';
    position: absolute; inset: -2px; border-radius: 50%;
    background: currentColor; opacity: .5;
    animation: liveping 1.8s ease-out infinite;
}
@keyframes liveping {
    0%   { transform:scale(.6); opacity:.6; }
    80%  { transform:scale(2.4); opacity:0; }
    100% { transform:scale(2.4); opacity:0; }
}
.pcard__dot {
    width: 6px; height: 6px; border-radius: 50%;
    display: block; flex-shrink: 0; background: currentColor;
}

/* description */
.pcard__desc {
    font-size: 13px; line-height: 1.6; color: #64748b;
    margin: 0 0 10px; flex-shrink: 0;
}
.dark .pcard__desc { color: #94a3b8; }
.pcard__readmore {
    display: inline;
    font-size: 12px; font-weight: 600;
    color: #6366f1;
    text-decoration: underline;
    text-underline-offset: 2px;
    text-decoration-color: rgba(99,102,241,0.4);
    transition: color .15s, text-decoration-color .15s;
    white-space: nowrap;
}
.pcard__readmore:hover {
    color: #4f46e5;
    text-decoration-color: rgba(79,70,229,0.7);
}
.dark .pcard__readmore { color: #a5b4fc; text-decoration-color: rgba(165,180,252,0.35); }
.dark .pcard__readmore:hover { color: #c7d2fe; text-decoration-color: rgba(199,210,254,0.6); }

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
                                        &ensp;<a href="{{ route('project.show', $project->slug) }}"
                                               class="pcard__readmore"
                                               onclick="event.stopPropagation()">Read more</a>
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

        {{-- Pagination dots --}}
        <div class="proj-pagination" id="dots_{{ $uid }}"></div>
    </div>
</div>

{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function () {
    function init() {
        if (typeof Swiper === 'undefined') {
            setTimeout(init, 50)
            return
        }

        new Swiper('#swiper_{{ $uid }}', {
            slidesPerView:  'auto',
            centeredSlides: true,
            spaceBetween:   20,
            loop:           true,
            grabCursor:     true,
            speed:          420,          // transition speed in ms — feels snappy but not harsh

            autoplay: {
                delay:                  4000,
                disableOnInteraction:   false,
                pauseOnMouseEnter:      true,
            },

            pagination: {
                el:              '#dots_{{ $uid }}',
                clickable:       true,
                bulletClass:     'proj-dot',
                bulletActiveClass: 'proj-dot--active',
            },
        })
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init)
    } else {
        init()
    }
}())
</script>

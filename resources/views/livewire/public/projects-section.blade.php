<section id="projects" class="py-32 relative overflow-hidden">

    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute w-[600px] h-[600px] bg-blue-500/10 blur-[160px] rounded-full bottom-0 right-[-200px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex items-center gap-4 mb-6" data-section-label>
            <span class="text-xs font-mono tracking-[0.2em] uppercase text-cyan-400">01 — Projects</span>
            <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/40 to-transparent"></div>
        </div>

        <div class="flex items-end justify-between mb-16">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white" data-section-heading>
                Things I've built
            </h2>
            <span class="text-slate-500 font-mono text-sm hidden md:block">{{ $projects->count() }} projects</span>
        </div>

    </div>


    @if ($projects->isEmpty())
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center py-24 text-slate-500">
                <p class="text-lg">No projects yet — check back soon.</p>
            </div>
        </div>
    @else

        <div class="swiper projects-swiper px-8">
            <div class="swiper-wrapper pb-16">
                @foreach ($projects as $project)
                    <div class="swiper-slide">
                        <div class="project-slide-card group">

                            <!-- Image -->
                            <div class="relative overflow-hidden rounded-t-2xl h-56">
                                @if ($project->thumbnail)
                                    <img src="/storage/{{ $project->thumbnail }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4zM3 17l9 4 9-4M3 12l9 4 9-4"/>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Status bar -->
                                <div class="absolute inset-x-0 top-0 h-[3px]
                                    @if ($project->status === 'live') bg-gradient-to-r from-green-400 to-emerald-400
                                    @elseif ($project->status === 'wip') bg-gradient-to-r from-orange-400 to-amber-400
                                    @else bg-gradient-to-r from-slate-500 to-slate-600 @endif">
                                </div>

                                <!-- Status badge -->
                                <div class="absolute top-4 right-4">
                                    @if ($project->status === 'live')
                                        <span class="flex items-center gap-1.5 text-xs px-3 py-1 rounded-full bg-green-500/20 text-green-400 border border-green-500/30 backdrop-blur-sm font-mono">
                                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>LIVE
                                        </span>
                                    @elseif ($project->status === 'wip')
                                        <span class="flex items-center gap-1.5 text-xs px-3 py-1 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/30 backdrop-blur-sm font-mono">
                                            <span class="w-1.5 h-1.5 bg-orange-400 rounded-full"></span>WIP
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col gap-4 flex-1">

                                <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug group-hover:text-cyan-400 transition-colors">
                                    {{ $project->title }}
                                </h3>

                                @if ($project->description)
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                                        {{ $project->description }}
                                    </p>
                                @endif

                                <!-- Tags -->
                                @if ($project->tags)
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach (array_slice($project->tags, 0, 4) as $tag)
                                            <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 font-mono">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                        @if (count($project->tags) > 4)
                                            <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800/80 text-slate-500 border border-slate-200 dark:border-slate-700 font-mono">
                                                +{{ count($project->tags) - 4 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex-1"></div>

                                <!-- Links -->
                                <div class="flex items-center gap-3 pt-2 border-t border-slate-200 dark:border-slate-800">
                                    @if ($project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank"
                                            class="flex items-center gap-1.5 text-xs font-semibold text-cyan-500 hover:text-cyan-400 transition font-mono">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                            </svg>
                                            Live Demo
                                        </a>
                                    @endif
                                    @if ($project->live_url && $project->repo_url)
                                        <span class="text-slate-300 dark:text-slate-700">·</span>
                                    @endif
                                    @if ($project->repo_url)
                                        <a href="{{ $project->repo_url }}" target="_blank"
                                            class="flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-cyan-400 transition font-mono">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/>
                                            </svg>
                                            Source Code
                                        </a>
                                    @endif
                                    @if (!$project->live_url && !$project->repo_url)
                                        <span class="text-xs text-slate-500 font-mono italic">No links yet</span>
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-button-prev projects-prev"></div>
            <div class="swiper-button-next projects-next"></div>
            <div class="swiper-pagination projects-pagination"></div>
        </div>

    @endif

</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof Swiper === 'undefined') return

        new Swiper('.projects-swiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 8,
                stretch: 0,
                depth: 120,
                modifier: 1.5,
                slideShadows: false,
            },
            pagination: {
                el: '.projects-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.projects-next',
                prevEl: '.projects-prev',
            },
            breakpoints: {
                0:    { slidesPerView: 1.1, spaceBetween: 16 },
                640:  { slidesPerView: 1.5, spaceBetween: 20 },
                1024: { slidesPerView: 2.5, spaceBetween: 30 },
                1280: { slidesPerView: 3,   spaceBetween: 30 },
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
                pauseOnMouseEnter: true,
            },
            loop: {{ $projects->count() > 2 ? 'true' : 'false' }},
        })
    })
</script>

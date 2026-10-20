<div class="min-h-screen pt-24 pb-32 relative overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute w-[600px] h-[600px] bg-cyan-400/10 blur-[180px] rounded-full top-[-200px] left-[-200px]">
        </div>
        <div
            class="absolute w-[500px] h-[500px] bg-purple-500/10 blur-[160px] rounded-full bottom-[-200px] right-[-200px]">
        </div>
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- BACK BUTTON -->
        <a href="{{ route('home') }}#projects" wire:navigate
            class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-cyan-400 transition mb-6 sm:mb-10 group font-mono">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Projects
        </a>


        <!-- HEADER -->
        <div class="mb-8 sm:mb-12">

            <!-- Status + date -->
            <div class="flex items-center gap-3 mb-6">
                @if ($project->status === 'live')
                    <span
                        class="flex items-center gap-1.5 text-xs px-3 py-1 rounded-full bg-green-500/15 text-green-400 border border-green-500/25 font-mono">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                        Live
                    </span>
                @elseif ($project->status === 'wip')
                    <span
                        class="flex items-center gap-1.5 text-xs px-3 py-1 rounded-full bg-orange-500/15 text-orange-400 border border-orange-500/25 font-mono">
                        <span class="w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                        Work in Progress
                    </span>
                @endif
                <span class="text-xs text-slate-500 font-mono">
                    {{ \Carbon\Carbon::parse($project->created_at)->format('M Y') }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 dark:text-white leading-tight mb-4 sm:mb-6">
                {{ $project->title }}
            </h1>

            @if ($project->description)
                <p class="text-base sm:text-lg md:text-xl text-slate-500 dark:text-slate-400 leading-relaxed max-w-3xl">
                    {!! $project->description !!}
                </p>
            @endif

        </div>


        <!-- ACTION BUTTONS -->
        <div class="flex flex-wrap gap-3 sm:gap-4 mb-10 sm:mb-16">
            @if ($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-400 to-blue-500 text-black font-bold text-sm hover:shadow-[0_0_24px_rgba(34,211,238,0.4)] transition-all duration-300 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    View Live
                </a>
            @endif
            @if ($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:border-cyan-400 hover:text-cyan-400 transition-all duration-300 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" />
                    </svg>
                    Source Code
                </a>
            @endif
        </div>


        @php
            $showMedia = [];
            if (is_array($project->media ?? null) && count($project->media) > 0) {
                $showMedia = $project->media;
            } elseif (!empty($project->thumbnail)) {
                $showMedia = [['type' => 'image', 'url' => $project->thumbnail]];
            }
        @endphp

        <!-- MEDIA GALLERY / HERO -->
        @if (!empty($showMedia))
            <div class="mb-10 sm:mb-16 md:mb-20" x-data="{ activeIdx: 0 }">
                <!-- Main Media Screen -->
                <div class="relative rounded-2xl overflow-hidden group shadow-2xl border border-slate-200/80 dark:border-white/10 bg-slate-950 aspect-video flex items-center justify-center">
                    @foreach ($showMedia as $gIdx => $gItem)
                        @php
                            $gType = is_array($gItem) ? ($gItem['type'] ?? 'image') : ($gItem->type ?? 'image');
                            $gPath = is_array($gItem) ? ($gItem['url'] ?? '') : ($gItem->url ?? '');
                            $isVid = $gType === 'video' || str_ends_with(strtolower((string) $gPath), '.mp4') || str_ends_with(strtolower((string) $gPath), '.webm');
                            $gFullUrl = str_starts_with((string) $gPath, 'http') ? $gPath : Storage::disk('r2')->url($gPath);
                        @endphp
                        <div class="absolute inset-0 w-full h-full flex items-center justify-center transition-all duration-300"
                            x-show="activeIdx === {{ $gIdx }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-98"
                            x-transition:enter-end="opacity-100 scale-100"
                        >
                            @if($isVid)
                                <video src="{{ $gFullUrl }}" controls class="w-full h-full object-contain" playsinline></video>
                            @else
                                <img src="{{ $gFullUrl }}" alt="{{ $project->title }}" class="w-full h-full object-cover" />
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Thumbnail Navigator Strip --}}
                @if (count($showMedia) > 1)
                    <div class="flex items-center gap-3 mt-4 overflow-x-auto pb-2">
                        @foreach ($showMedia as $thumbIdx => $thumbItem)
                            @php
                                $tType = is_array($thumbItem) ? ($thumbItem['type'] ?? 'image') : ($thumbItem->type ?? 'image');
                                $tPath = is_array($thumbItem) ? ($thumbItem['url'] ?? '') : ($thumbItem->url ?? '');
                                $isVid = $tType === 'video' || str_ends_with(strtolower((string) $tPath), '.mp4') || str_ends_with(strtolower((string) $tPath), '.webm');
                                $tFullUrl = str_starts_with((string) $tPath, 'http') ? $tPath : Storage::disk('r2')->url($tPath);
                            @endphp
                            <button type="button" @click="activeIdx = {{ $thumbIdx }}"
                                class="relative rounded-xl overflow-hidden flex-shrink-0 w-24 h-16 border-2 transition-all duration-200 cursor-pointer"
                                :class="activeIdx === {{ $thumbIdx }} ? 'border-cyan-400 ring-2 ring-cyan-400/30 scale-105' : 'border-slate-300 dark:border-slate-800 opacity-60 hover:opacity-100'"
                            >
                                @if($isVid)
                                    <video src="{{ $tFullUrl }}" class="w-full h-full object-cover" muted preload="metadata"></video>
                                    <span class="absolute inset-0 flex items-center justify-center bg-black/40 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6.3 2.841A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.269l9.344-5.89a1.5 1.5 0 0 0 0-2.538L6.3 2.84z" />
                                        </svg>
                                    </span>
                                @else
                                    <img src="{{ $tFullUrl }}" class="w-full h-full object-cover">
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif


        <!-- TECH STACK -->
        @if ($project->tags && count($project->tags) > 0)
            <div class="mb-10 sm:mb-16 md:mb-20">
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-xs font-mono tracking-[0.2em] uppercase text-cyan-400">Tech Stack</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/40 to-transparent"></div>
                </div>
                <div class="flex flex-wrap gap-3">
                    @foreach ($project->tags as $tag)
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 text-slate-700 dark:text-slate-300 text-sm font-mono hover:border-cyan-400/50 hover:text-cyan-400 transition-all duration-200">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- RELATED PROJECTS --}}
        @if ($related->isNotEmpty())
            <div>
                <div class="flex items-center gap-4 mb-10">
                    <span class="text-xs font-mono tracking-[0.2em] uppercase text-cyan-400">More Projects</span>
                    <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/40 to-transparent"></div>
                </div>
                <x-project-slider :projects="$related" />
            </div>
        @endif

    </div>
</div>

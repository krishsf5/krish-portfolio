<section id="experience" class="py-12 sm:py-16 lg:py-20 relative overflow-hidden">

    {{-- Ambient glowing background --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute top-[30%] right-[-120px] w-[500px] h-[500px] rounded-full"
            style="background: radial-gradient(circle, rgba(34,211,238,0.06) 0%, transparent 70%);"></div>
        <div class="absolute bottom-[10%] left-[-150px] w-[500px] h-[500px] rounded-full"
            style="background: radial-gradient(circle, rgba(99,102,241,0.05) 0%, transparent 70%);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10">

        {{-- Section Header --}}
        <div class="mb-10 sm:mb-12">
            <div class="flex items-center gap-4 mb-3 sm:mb-4">
                <span class="text-[11px] font-mono tracking-[0.25em] uppercase text-cyan-400">02 — Experience</span>
                <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/40 to-transparent"></div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                <div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Work Experience & Roles
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base mt-2 max-w-2xl">
                        Production engineering, scalable backend architecture, and full-stack software development.
                    </p>
                </div>
                @if ($experiences->isNotEmpty())
                    <span class="text-slate-500 font-mono text-xs hidden sm:block">
                        {{ $experiences->count() }} {{ Str::plural('Role', $experiences->count()) }}
                    </span>
                @endif
            </div>
        </div>

        @if ($experiences->isEmpty())
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30 p-12 text-center">
                <p class="font-mono text-slate-500 text-sm">Experience records loading or updating — check back soon.</p>
            </div>
        @else
            {{-- Modern Bento Grid Layout --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">

                @foreach ($experiences as $index => $exp)
                    @php
                        // In bento grid, make the first / featured card occupy more width (e.g. 12 cols if only 1, or 7/12 cols if multiple)
                        $isSingle = $experiences->count() === 1;
                        $isFeatured = $index === 0 && !$isSingle;
                        $colSpan = $isSingle ? 'lg:col-span-12' : ($isFeatured ? 'lg:col-span-7' : ($index === 1 ? 'lg:col-span-5' : 'lg:col-span-6'));
                    @endphp

                    <div class="{{ $colSpan }} group relative rounded-2xl border border-slate-200/80 dark:border-slate-800/80 bg-white/70 dark:bg-slate-900/60 backdrop-blur-xl p-6 sm:p-8 flex flex-col justify-between transition-all duration-300 hover:border-cyan-500/50 hover:shadow-[0_0_35px_rgba(34,211,238,0.12)] hover:-translate-y-0.5">

                        {{-- Subtle card top glow --}}
                        <div class="absolute -top-px left-10 right-10 h-px bg-gradient-to-r from-transparent via-cyan-400/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div>
                            {{-- Top Metadata Bar: Role Badges, Company, Period --}}
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                                <div class="flex flex-wrap items-center gap-2">
                                    {{-- Role / Badge chips --}}
                                    @if (!empty($exp->badge))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-medium bg-cyan-500/10 text-cyan-500 dark:text-cyan-400 border border-cyan-500/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                                            {{ $exp->badge }}
                                        </span>
                                    @endif

                                    @if (!empty($exp->type))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-mono text-indigo-500 dark:text-indigo-400 bg-indigo-500/10 border border-indigo-500/20">
                                            {{ $exp->type }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Period Chip --}}
                                @if (!empty($exp->period))
                                    <div class="inline-flex items-center gap-1.5 text-xs font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800/80 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-700/50">
                                        <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $exp->period }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Role Title & Company Header --}}
                            <div class="mb-4">
                                <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white group-hover:text-cyan-400 transition-colors">
                                    {{ $exp->role }}
                                </h3>

                                <div class="flex flex-wrap items-center gap-3 mt-1.5">
                                    @if (!empty($exp->company_url))
                                        <a href="{{ $exp->company_url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-1.5 text-base font-semibold text-cyan-600 dark:text-cyan-400 hover:underline">
                                            <span>{{ $exp->company }}</span>
                                            <svg class="w-4 h-4 opacity-70 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-base font-semibold text-slate-800 dark:text-slate-200">
                                            {{ $exp->company }}
                                        </span>
                                    @endif

                                    @if (!empty($exp->location))
                                        <span class="text-slate-400 dark:text-slate-600">•</span>
                                        <span class="inline-flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $exp->location }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Description --}}
                            @if (!empty($exp->description))
                                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-5">
                                    {{ $exp->description }}
                                </p>
                            @endif

                            {{-- Architectural Highlights / Bullet Points --}}
                            @if (!empty($exp->highlights) && is_array($exp->highlights))
                                <div class="mt-4 pt-4 border-t border-slate-200/60 dark:border-slate-800/70">
                                    <div class="flex items-center gap-2 mb-3">
                                        <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                        <span class="text-[11px] font-mono tracking-wider uppercase text-slate-500 dark:text-slate-400">
                                            Architectural Highlights
                                        </span>
                                    </div>
                                    <ul class="space-y-2.5">
                                        @foreach ($exp->highlights as $highlight)
                                            <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-normal">
                                                <span class="mt-1 w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0 shadow-[0_0_8px_rgba(34,211,238,0.8)]"></span>
                                                <span>{{ is_array($highlight) ? ($highlight['text'] ?? json_encode($highlight)) : $highlight }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- Technologies / Stack Tags --}}
                        @if (!empty($exp->technologies) && is_array($exp->technologies))
                            <div class="mt-6 pt-5 border-t border-slate-200/60 dark:border-slate-800/70">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($exp->technologies as $tech)
                                        <span class="text-[11px] font-mono px-2.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800/90 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700/60 group-hover:border-cyan-500/30 transition-colors">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach

            </div>
        @endif

    </div>

</section>

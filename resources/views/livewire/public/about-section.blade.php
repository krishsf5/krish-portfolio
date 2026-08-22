<section id="about" class="relative py-20 sm:py-24 lg:py-32 overflow-hidden">

    <!-- Background glows -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute w-[600px] h-[600px] bg-cyan-400/15 blur-[160px] rounded-full top-[-200px] right-[-100px]"></div>
        <div class="absolute w-[500px] h-[500px] bg-purple-500/15 blur-[160px] rounded-full bottom-[-200px] left-[-100px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">

        <!-- SECTION LABEL -->
        <div class="flex items-center gap-4 mb-10 sm:mb-14 lg:mb-20" data-about-label>
            <span class="text-xs font-mono tracking-[0.2em] uppercase text-cyan-400">02 — About</span>
            <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/40 to-transparent"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            <!-- PHOTO SIDE -->
            <div class="relative flex justify-center lg:justify-start" data-about-photo>

                <!-- Decorative rings -->
                <div class="absolute w-[460px] h-[460px] rounded-full border border-cyan-400/10 animate-spin-slow top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 hidden lg:block"></div>
                <div class="absolute w-[380px] h-[380px] rounded-full border border-purple-400/10 animate-spin-slow-reverse top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 hidden lg:block"></div>

                <div class="relative group w-full max-w-[360px] sm:max-w-[404px]">

                    <!-- Glow -->
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-cyan-400/30 to-purple-500/30 blur-3xl opacity-60 group-hover:opacity-90 transition-opacity duration-700 scale-105"></div>

                    <!-- Card -->
                    <div class="relative bg-white dark:bg-[#0c1120] border border-slate-200/80 dark:border-white/10 rounded-3xl p-4 sm:p-7 shadow-2xl shadow-indigo-500/10 dark:shadow-none backdrop-blur-sm overflow-hidden">

                        <!-- Corner accents -->
                        <div class="absolute top-0 left-0 w-12 h-12 border-t-2 border-l-2 border-cyan-400/50 rounded-tl-3xl"></div>
                        <div class="absolute bottom-0 right-0 w-12 h-12 border-b-2 border-r-2 border-purple-400/50 rounded-br-3xl"></div>

                        <div class="w-full rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-900/60 flex items-center justify-center">
                            <img
                                src="{{ str_starts_with($avatar ?? '', 'http') ? $avatar : ($avatar ? Storage::disk('r2')->url($avatar) : '') }}"
                                alt="{{ $about?->full_name ?? 'Krish Bhojwani' }}"
                                class="w-full h-auto object-contain rounded-2xl mx-auto transition-transform duration-500 group-hover:scale-[1.02]"
                            />
                        </div>

                        <!-- Availability badge -->
                        <div class="flex justify-center mt-5">
                            @php $availability = $about?->availability ?? 'available'; @endphp
                            @if ($availability === 'available')
                                <span class="flex items-center gap-2 text-sm px-5 py-2 rounded-full bg-green-500/10 text-green-400 border border-green-500/20">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    Available for work
                                </span>
                            @elseif ($availability === 'open')
                                <span class="flex items-center gap-2 text-sm px-5 py-2 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                                    Open to opportunities
                                </span>
                            @else
                                <span class="flex items-center gap-2 text-sm px-5 py-2 rounded-full bg-red-500/10 text-red-400 border border-red-500/20">
                                    <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                                    Not available
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>


            <!-- TEXT SIDE -->
            <div class="space-y-7 sm:space-y-8" data-about-text>

                <div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-4">
                        {{ $about?->title ?? 'Building systems,' }}
                        <span class="text-cyan-400">{{ $about ? '' : 'not just websites' }}</span>
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-base sm:text-lg">
                        {{ $about?->bio ?? "I'm Krish, a computer engineering student focused on backend systems and full-stack development. I enjoy building tools that solve real problems — dashboards, CMS systems, automation tools and developer-focused software." }}
                    </p>
                </div>


                <!-- STATS -->
                @php
                    $customStats = is_array($about?->stats ?? null) ? $about->stats : [];
                    $allStats = collect([(object)['label' => 'Projects Built', 'value' => (string)$liveProjectCount]])
                        ->merge(collect($customStats)->map(fn($item) => (object)$item));
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                    @foreach ($allStats as $stat)
                        @php
                            $statLabel = is_object($stat) ? ($stat->label ?? '') : ($stat['label'] ?? '');
                            $statVal   = (string)(is_object($stat) ? ($stat->value ?? '') : ($stat['value'] ?? ''));
                            preg_match('/^(\d+)(.*)$/', $statVal, $matches);
                            $numericVal = $matches[1] ?? null;
                            $suffix     = $matches[2] ?? '';
                        @endphp
                        <div class="stat-counter-card group">
                            <p class="text-2xl sm:text-3xl font-bold text-cyan-400 tabular-nums">
                                @if ($numericVal !== null)
                                    <span class="counter-val" data-count="{{ $numericVal }}" data-suffix="{{ $suffix }}">{{ $statVal }}</span>
                                @else
                                    {{ $statVal }}
                                @endif
                            </p>
                            <p class="text-sm text-slate-700 dark:text-slate-400 mt-1">{{ $statLabel }}</p>
                        </div>
                    @endforeach
                </div>


                <!-- BUTTONS -->
                <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:gap-4 pt-2">
                    @if ($resumeUrl)
                        <a href="{{ $resumeUrl }}" target="_blank"
                            class="inline-flex justify-center px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-400 to-blue-500 text-black font-semibold hover:shadow-[0_0_20px_rgba(34,211,238,0.4)] transition-all duration-300 hover:-translate-y-0.5">
                            Download Resume
                        </a>
                    @endif
                    <a href="#projects"
                        class="inline-flex justify-center px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 hover:border-cyan-400 dark:hover:border-cyan-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 hover:-translate-y-0.5">
                        View Projects
                    </a>
                    <a href="#contact"
                        class="inline-flex justify-center px-6 py-3 rounded-xl border border-slate-300 dark:border-slate-700 hover:border-cyan-400 dark:hover:border-cyan-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-all duration-300 hover:-translate-y-0.5">
                        Contact Me
                    </a>
                </div>


                <!-- SOCIALS -->
                <div class="flex flex-wrap gap-x-6 gap-y-3 pt-2">
                    <a href="{{ $about?->github_url ?? 'https://gitlab.com/krishtbhojwani' }}" target="_blank"
                        class="flex items-center gap-2 text-slate-500 hover:text-cyan-400 transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 01-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 014.82 2a.43.43 0 01.58 0 .42.42 0 01.11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0118.6 2a.43.43 0 01.58 0 .42.42 0 01.11.18l2.44 7.51L23 13.45a.84.84 0 01-.35.94z"/>
                        </svg>
                        GitLab
                    </a>
                    <a href="{{ $about?->linkedin_url ?? 'https://linkedin.com/in/krish-bhojwani' }}" target="_blank"
                        class="flex items-center gap-2 text-slate-500 hover:text-cyan-400 transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>
                    <a href="mailto:{{ $about?->email ?? 'krishtbhojwani@gmail.com' }}"
                        class="flex items-center gap-2 text-slate-500 hover:text-cyan-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        Email
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

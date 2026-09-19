<section id="skills" class="py-12 sm:py-16 lg:py-20 relative overflow-hidden">

    <div class="absolute inset-0 -z-10">
        <div class="absolute w-[400px] h-[400px] bg-cyan-400/10 blur-[140px] rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 mb-6 sm:mb-8">
        <div class="flex items-center gap-4 mb-4" data-section-label>
            <span class="text-xs font-mono tracking-[0.2em] uppercase text-cyan-400">03 — Tech Stack</span>
            <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/40 to-transparent"></div>
        </div>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white" data-section-heading>
            Technologies I work with
        </h2>
    </div>

    @if ($row1->isNotEmpty())

        <!-- ROW 1: scrolls left -->
        <div class="marquee-wrapper mb-5">
            <div class="marquee-track">
                @foreach ([$row1, $row1] as $set)
                    @foreach ($set as $skill)
                        <div class="marquee-chip group">
                            @if ($skill->icon)
                                <i class="{{ $skill->icon }} text-xl text-cyan-400 group-hover:scale-110 transition-transform shrink-0"></i>
                            @endif
                            <span class="font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $skill->name }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        <!-- ROW 2: scrolls right -->
        <div class="marquee-wrapper">
            <div class="marquee-track marquee-reverse">
                @foreach ([$row2, $row2] as $set)
                    @foreach ($set as $skill)
                        <div class="marquee-chip group">
                            @if ($skill->icon)
                                <i class="{{ $skill->icon }} text-xl text-purple-400 group-hover:scale-110 transition-transform shrink-0"></i>
                            @endif
                            <span class="font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ $skill->name }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

    @endif


    <!-- CATEGORY BREAKDOWN -->
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 mt-12 sm:mt-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            @foreach (['Frontend', 'Backend', 'Database', 'Tools'] as $category)
                @php $catSkills = $skills->where('category', $category); @endphp
                @if ($catSkills->isNotEmpty())
                    <div class="category-card group" data-category-card>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-5 rounded-full bg-gradient-to-b from-cyan-400 to-blue-500"></div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">{{ $category }}</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($catSkills as $skill)
                                <span class="skill-pill">
                                    @if ($skill->icon)
                                        <i class="{{ $skill->icon }} text-base"></i>
                                    @endif
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</section>

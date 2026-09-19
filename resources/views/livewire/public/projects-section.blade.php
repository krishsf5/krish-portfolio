<section id="projects" class="py-20 sm:py-24 lg:py-28 relative overflow-hidden">

    {{-- Background atmosphere --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute bottom-[-100px] right-[-150px] w-[600px] h-[600px] rounded-full"
            style="background: radial-gradient(circle, rgba(34,211,238,0.055) 0%, transparent 65%);"></div>
        <div class="absolute top-[20%] left-[-100px] w-[400px] h-[400px] rounded-full"
            style="background: radial-gradient(circle, rgba(99,102,241,0.04) 0%, transparent 65%);"></div>
    </div>

    {{-- Header --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 mb-10 sm:mb-14">
        <div class="flex items-center gap-4 mb-5">
            <span class="text-[11px] font-mono tracking-[0.25em] uppercase text-cyan-400">01 — Projects</span>
            <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/30 to-transparent"></div>
        </div>
        <div class="flex items-end justify-between">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-slate-900 dark:text-white">
                Things I've built
            </h2>
            @if ($projects->isNotEmpty())
                <span class="hidden md:block text-slate-500 font-mono text-xs">
                    {{ $projects->count() }} {{ Str::plural('project', $projects->count()) }}
                </span>
            @endif
        </div>
    </div>

    @if ($projects->isEmpty())
        <div class="max-w-7xl mx-auto px-6 md:px-10 py-20 text-center">
            <p class="font-mono text-slate-500 text-sm">No projects yet — check back soon.</p>
        </div>
    @else
        <x-project-slider :projects="$projects" />
    @endif

</section>

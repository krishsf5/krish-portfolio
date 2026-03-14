<div class="space-y-8 max-w-5xl">

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

        <div class="stat-card p-10">
            <p class="text-sm text-slate-400">Total Projects</p>
            <h3 class="text-5xl font-bold text-cyan-400 mt-3">
                {{ $totalProjects }}
            </h3>
        </div>

        <div class="stat-card p-10">
            <p class="text-sm text-slate-400">Live Projects</p>
            <h3 class="text-5xl font-bold text-green-400 mt-3">
                {{ $liveProjects }}
            </h3>
        </div>

        <div class="stat-card p-10">
            <p class="text-sm text-slate-400">WIP Projects</p>
            <h3 class="text-5xl font-bold text-orange-400 mt-3">
                {{ $wipProjects }}
            </h3>
        </div>

        <div class="stat-card p-10">
            <p class="text-sm text-slate-400">Hidden Projects</p>
            <h3 class="text-5xl font-bold text-red-400 mt-3">
                {{ $hiddenProjects }}
            </h3>
        </div>

    </div>


    {{-- PROJECTS --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-cyan-400">
                Projects
            </h2>
        </div>

        <livewire:projects.project-manager />
    </div>

</div>

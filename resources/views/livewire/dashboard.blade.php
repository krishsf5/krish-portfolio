<div>
    {{-- Page Header --}}
    <div class="flex items-end justify-between mb-6">
        <div>
            <h1 class="text-xl font-medium text-slate-800 dark:text-slate-100 tracking-tight">Projects</h1>
            <p class="text-xs font-mono text-slate-400 dark:text-navy-300 mt-1">Manage what appears on your portfolio</p>
        </div>
        <button class="btn-primary">+ New Project</button>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-4 gap-3 mb-6">
        <div class="stat-card">
            <div class="stat-label">TOTAL</div>
            <div class="stat-value">{{ $totalProjects }} <span class="text-xs text-slate-400 dark:text-navy-300 font-mono">projects</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">LIVE</div>
            <div class="stat-value text-cyan-500 dark:text-cyan-400">{{ $liveProjects }} <span class="text-xs font-mono">visible</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">IN PROGRESS</div>
            <div class="stat-value text-orange-400">{{ $wipProjects }} <span class="text-xs font-mono">wip</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">HIDDEN</div>
            <div class="stat-value text-slate-400">{{ $hiddenProjects }} <span class="text-xs font-mono">hidden</span></div>
        </div>
    </div>

    {{-- Projects Component --}}
    @livewire('projects.project-manager')
</div>

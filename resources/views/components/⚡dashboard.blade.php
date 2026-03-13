<div>
    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="mb-4 px-4 py-2.5 rounded-lg bg-cyan-50 dark:bg-cyan-950/30 border border-cyan-200 dark:border-cyan-900/50 text-xs font-mono text-cyan-600 dark:text-cyan-400"
        >
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-end justify-between mb-6">
        <div>
            <h1 class="text-xl font-medium text-slate-800 dark:text-slate-100 tracking-tight">Projects</h1>
            <p class="text-xs font-mono text-slate-400 dark:text-navy-300 mt-1">Manage what appears on your portfolio</p>
        </div>
        <button
            onclick="Livewire.dispatch('open-create-modal')"
            class="btn-primary"
        >
            + New Project
        </button>
    </div>

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

    @livewire('projects.project-manager')
</div>

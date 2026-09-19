<div class="max-w-7xl space-y-10">

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-4xl font-bold tracking-tight text-white">
                Dashboard
            </h1>

            <p class="text-slate-400 mt-2">
                Manage your portfolio content
            </p>
        </div>

        <div class="flex items-center gap-3 text-xs text-slate-400">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            System Online
        </div>

    </div>


    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- TOTAL PROJECTS --}}
        <div class="stat-card p-6 relative overflow-hidden">

            <div class="absolute inset-x-0 top-0 h-[3px] bg-cyan-400"></div>

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">
                        Total Projects
                    </p>

                    <h3 class="text-4xl font-bold text-cyan-400 mt-3">
                        {{ $totalProjects }}
                    </h3>
                </div>

                <div class="text-cyan-400 opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7l9-4 9 4-9 4-9-4zM3 17l9 4 9-4M3 12l9 4 9-4"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- LIVE PROJECTS --}}
        <div class="stat-card p-6 relative overflow-hidden">

            <div class="absolute inset-x-0 top-0 h-[3px] bg-green-400"></div>

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">
                        Live Projects
                    </p>

                    <h3 class="text-4xl font-bold text-green-400 mt-3">
                        {{ $liveProjects }}
                    </h3>
                </div>

                <div class="text-green-400 opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- WIP --}}
        <div class="stat-card p-6 relative overflow-hidden">

            <div class="absolute inset-x-0 top-0 h-[3px] bg-orange-400"></div>

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">
                        Work In Progress
                    </p>

                    <h3 class="text-4xl font-bold text-orange-400 mt-3">
                        {{ $wipProjects }}
                    </h3>
                </div>

                <div class="text-orange-400 opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6l4 2"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- HIDDEN --}}
        <div class="stat-card p-6 relative overflow-hidden">

            <div class="absolute inset-x-0 top-0 h-[3px] bg-red-400"></div>

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400">
                        Hidden Projects
                    </p>

                    <h3 class="text-4xl font-bold text-red-400 mt-3">
                        {{ $hiddenProjects }}
                    </h3>
                </div>

                <div class="text-red-400 opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3l18 18M10.5 10.5a3 3 0 004.243 4.243"/>
                    </svg>
                </div>

            </div>

        </div>

    </div>



    {{-- PROJECT MANAGER PANEL --}}
    <div class="card p-8">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h2 class="text-2xl font-bold text-cyan-400">
                    Projects
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Manage portfolio projects
                </p>
            </div>

        </div>

        <hr class="divider mb-6">

        <livewire:projects.project-manager :key="'dashboard-project-manager'" />

    </div>

</div>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-white">
                Project Manager
            </h2>

            <p class="text-sm text-slate-400 mt-1">
                Create, edit and manage portfolio projects
            </p>
        </div>

        <a href="{{ route('projects.create') }}" wire:navigate class="btn-primary flex items-center gap-2">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>

            New Project

        </a>

    </div>


    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="px-4 py-3 rounded-lg text-xs font-mono
                   border border-cyan-400/20
                   bg-cyan-400/10
                   text-cyan-300">

            {{ session('success') }}

        </div>
    @endif



    {{-- EMPTY STATE --}}
    @if ($projects->isEmpty())

        <div class="card p-16 text-center">

            <div class="flex flex-col items-center gap-4">

                <div
                    class="w-14 h-14 rounded-xl
                            bg-cyan-400/10
                            border border-cyan-400/20
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-cyan-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4z" />

                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l9 4 9-4" />

                    </svg>

                </div>

                <div>
                    <p class="text-sm text-slate-200">
                        No projects yet
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Click <span class="text-cyan-400">New Project</span> to create your first entry.
                    </p>
                </div>

            </div>

        </div>
    @else
        {{-- PROJECT GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach ($projects as $project)
                <div class="card card-hover overflow-hidden flex flex-col">

                    {{-- THUMBNAIL --}}
                    <div class="relative">

                        @if ($project->thumbnail)
                            <img src="/storage/{{ $project->thumbnail }}" class="w-full h-44 object-cover">
                        @else
                            <div
                                class="w-full h-44 flex items-center justify-center
                                        bg-[#0c1120] text-slate-500 text-xs">

                                No Image

                            </div>
                        @endif


                        {{-- STATUS INDICATOR --}}
                        <div
                            class="absolute inset-x-0 top-0 h-[3px]

@if ($project->status === 'live') bg-green-400

@elseif ($project->status === 'wip')
bg-orange-400

@else
bg-red-400 @endif
">
                        </div>


                        {{-- STATUS BADGE --}}
                        <div class="absolute top-3 left-3">

                            @if ($project->status === 'live')
                                <span class="badge-live flex items-center gap-1">

                                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>

                                    LIVE

                                </span>
                            @elseif($project->status === 'wip')
                                <span class="badge-wip flex items-center gap-1">

                                    <span class="w-2 h-2 rounded-full bg-orange-400"></span>

                                    WIP

                                </span>
                            @else
                                <span class="badge-hidden flex items-center gap-1">

                                    <span class="w-2 h-2 rounded-full bg-red-400"></span>

                                    HIDDEN

                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- CARD CONTENT --}}
                    <div class="p-6 flex flex-col gap-4 flex-1">

                        {{-- TITLE --}}
                        <h3 class="text-lg font-semibold text-white">
                            {{ $project->title }}
                        </h3>


                        {{-- DESCRIPTION --}}
                        <p class="text-sm text-slate-400 line-clamp-2">
                            {{ $project->description }}
                        </p>


                        {{-- TAGS --}}
                        @if ($project->tags)
                            <div class="flex flex-wrap gap-2">

                                @foreach ($project->tags as $tag)
                                    <span
                                        class="px-2 py-1 text-xs rounded
                                                 bg-[#080a14]
                                                 border border-[#19243a]
                                                 text-slate-300">

                                        {{ $tag }}

                                    </span>
                                @endforeach

                            </div>
                        @endif


                        {{-- DIVIDER --}}
                        <div class="divider"></div>


                        {{-- ACTIONS --}}
                        <div class="flex items-center justify-between">

                            <div class="flex gap-2">

                                <button wire:click="edit({{ $project->id }})" class="btn-edit">
                                    Edit
                                </button>

                                <button wire:click="confirmDelete({{ $project->id }})" class="btn-delete">
                                    Delete
                                </button>

                            </div>


                            {{-- VISIBILITY --}}
                            <button wire:click="toggleVisibility({{ $project->id }})"
                                class="p-2 rounded-md
                                       border border-[#19243a]
                                       hover:border-cyan-400
                                       transition"
                                title="{{ $project->is_visible ? 'Hide project' : 'Show project' }}">

                                @if ($project->is_visible)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />

                                        <circle cx="12" cy="12" r="3" />

                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />

                                    </svg>
                                @endif

                            </button>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    @endif



    {{-- MODALS (kept exactly same) --}}
    {{-- Your modal code below can remain unchanged --}}

</div>

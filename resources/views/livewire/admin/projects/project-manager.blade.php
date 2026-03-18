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

        <button wire:click="create" class="btn-primary flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            New Project
        </button>

    </div>


    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="px-4 py-3 rounded-lg text-xs font-mono border border-cyan-400/20 bg-cyan-400/10 text-cyan-300">
            {{ session('success') }}
        </div>
    @endif


    {{-- EMPTY STATE --}}
    @if ($projects->isEmpty())
        <div class="card p-16 text-center">
            <div class="flex flex-col items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l9 4 9-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-200">No projects yet</p>
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
                            <div class="w-full h-44 flex items-center justify-center bg-[#0c1120] text-slate-500 text-xs">
                                No Image
                            </div>
                        @endif

                        {{-- STATUS BAR --}}
                        <div class="absolute inset-x-0 top-0 h-[3px]
                            @if ($project->status === 'live') bg-green-400
                            @elseif ($project->status === 'wip') bg-orange-400
                            @else bg-red-400 @endif">
                        </div>

                        {{-- STATUS BADGE --}}
                        <div class="absolute top-3 left-3">
                            @if ($project->status === 'live')
                                <span class="badge-live flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                    LIVE
                                </span>
                            @elseif ($project->status === 'wip')
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

                        <h3 class="text-lg font-semibold text-white">
                            {{ $project->title }}
                        </h3>

                        <p class="text-sm text-slate-400 line-clamp-2">
                            {{ $project->description }}
                        </p>

                        @if ($project->tags)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($project->tags as $tag)
                                    <span class="px-2 py-1 text-xs rounded bg-[#080a14] border border-[#19243a] text-slate-300">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="divider"></div>

                        {{-- ACTIONS --}}
                        <div class="flex items-center justify-between">

                            <div class="flex gap-2">
                                <button wire:click="edit({{ $project->id }})" class="btn-edit">Edit</button>
                                <button wire:click="confirmDelete({{ $project->id }})" class="btn-delete">Delete</button>
                            </div>

                            {{-- VISIBILITY TOGGLE --}}
                            <button wire:click="toggleVisibility({{ $project->id }})"
                                class="p-2 rounded-md border border-[#19243a] hover:border-cyan-400 transition"
                                title="{{ $project->is_visible ? 'Hide project' : 'Show project' }}">
                                @if ($project->is_visible)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
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


    {{-- CREATE / EDIT MODAL --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
             x-data x-on:keydown.escape.window="$wire.closeModal()">

            <div class="card w-full max-w-xl p-8 space-y-6 shadow-2xl max-h-[90vh] overflow-y-auto">

                {{-- MODAL HEADER --}}
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white">
                        {{ $editingId ? 'Edit Project' : 'New Project' }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">

                    {{-- TITLE --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">
                            Title <span class="text-red-400">*</span>
                        </label>
                        <input wire:model="title" type="text" placeholder="E-Commerce Platform"
                            class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                        @error('title') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Description</label>
                        <textarea wire:model="description" rows="3" placeholder="What does this project do?"
                            class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition resize-y"></textarea>
                        @error('description') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- STATUS + TAGS --}}
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">
                                Status <span class="text-red-400">*</span>
                            </label>
                            <select wire:model="status"
                                class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 focus:border-cyan-400 focus:outline-none transition">
                                <option value="wip">WIP</option>
                                <option value="live">Live</option>
                                <option value="hidden">Hidden</option>
                            </select>
                            @error('status') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Tags</label>
                            <input wire:model="tags" type="text" placeholder="Laravel, MySQL, Alpine.js"
                                class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                            @error('tags') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    {{-- URLS --}}
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Live URL</label>
                            <input wire:model="live_url" type="text" placeholder="https://yourproject.com"
                                class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                            @error('live_url') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Repo URL</label>
                            <input wire:model="repo_url" type="text" placeholder="https://gitlab.com/..."
                                class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                            @error('repo_url') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    {{-- THUMBNAIL --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Thumbnail</label>
                        <input wire:model="thumbnail" type="file" accept="image/*"
                            class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400/10 file:text-cyan-400 hover:file:bg-cyan-400/20 transition cursor-pointer">
                        @error('thumbnail') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror

                        {{-- EXISTING THUMBNAIL PREVIEW --}}
                        @if ($editingId && !$thumbnail)
                            @php $existingThumb = \App\Models\Project::find($editingId)?->thumbnail; @endphp
                            @if ($existingThumb)
                                <img src="/storage/{{ $existingThumb }}" class="mt-2 h-20 rounded-lg object-cover">
                            @endif
                        @endif

                        {{-- NEW UPLOAD PREVIEW --}}
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="mt-2 h-20 rounded-lg object-cover">
                        @endif
                    </div>

                </div>

                {{-- MODAL ACTIONS --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button wire:click="closeModal" class="btn-ghost px-5 py-2">Cancel</button>
                    <button wire:click="save" class="btn-primary px-5 py-2">
                        {{ $editingId ? 'Update Project' : 'Create Project' }}
                    </button>
                </div>

            </div>
        </div>
    @endif


    {{-- DELETE CONFIRM MODAL --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="card w-full max-w-sm p-8 space-y-6 text-center">
                <h3 class="text-lg font-bold text-white">Delete Project?</h3>
                <p class="text-sm text-slate-400">This cannot be undone. The thumbnail will also be deleted.</p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeModal" class="btn-ghost px-5 py-2">Cancel</button>
                    <button wire:click="delete" class="btn-delete px-5 py-2">Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>

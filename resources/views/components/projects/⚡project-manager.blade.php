<div>
    {{-- Flash Message --}}
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

    {{-- Empty State --}}
    @if ($projects->isEmpty())
        <div class="card p-16 text-center">
            <p class="text-slate-400 dark:text-navy-200 font-mono text-sm mb-1">No projects yet</p>
            <p class="text-slate-300 dark:text-navy-300 font-mono text-xs">Click <span class="text-cyan-500">+ New Project</span> to add your first one.</p>
        </div>
    @else

    {{-- Project Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach ($projects as $project)
        <div class="card-hover p-4 flex flex-col gap-3">

            {{-- Badge + Title --}}
            <div class="flex items-start justify-between gap-2">
                <div>
                    @if ($project->status === 'live' && $project->is_visible)
                        <span class="badge-live mb-2 inline-flex">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 dark:bg-cyan-400"></span> LIVE
                        </span>
                    @elseif ($project->status === 'wip')
                        <span class="badge-wip mb-2 inline-flex">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> WIP
                        </span>
                    @else
                        <span class="badge-hidden mb-2 inline-flex">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> HIDDEN
                        </span>
                    @endif
                    <h3 class="text-sm font-medium text-slate-800 dark:text-slate-100 leading-snug">
                        {{ $project->title }}
                    </h3>
                </div>
            </div>

            {{-- Description --}}
            @if ($project->description)
                <p class="text-xs text-slate-400 dark:text-navy-200 leading-relaxed line-clamp-2">
                    {{ $project->description }}
                </p>
            @endif

            {{-- Tags --}}
            @if (!empty($project->tags))
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($project->tags as $tag)
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-slate-100 dark:bg-navy-700 text-slate-500 dark:text-navy-200 border border-slate-200 dark:border-navy-500">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

            {{-- Links --}}
            @if ($project->live_url || $project->repo_url)
                <div class="flex gap-2">
                    @if ($project->live_url)
                        <a href="{{ $project->live_url }}" target="_blank"
                           class="text-[10px] font-mono text-cyan-500 dark:text-cyan-400 hover:underline">
                            Live ↗
                        </a>
                    @endif
                    @if ($project->repo_url)
                        <a href="{{ $project->repo_url }}" target="_blank"
                           class="text-[10px] font-mono text-slate-400 dark:text-navy-200 hover:underline">
                            Repo ↗
                        </a>
                    @endif
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-2 pt-1 border-t border-slate-100 dark:border-navy-600 mt-auto">
                <button wire:click="edit({{ $project->id }})" class="btn-edit">Edit</button>
                <button wire:click="confirmDelete({{ $project->id }})" class="btn-delete">Delete</button>

                {{-- Visibility Toggle --}}
                <div class="flex items-center gap-2 ml-auto">
                    <span class="text-[10px] font-mono text-slate-400 dark:text-navy-300">
                        {{ $project->is_visible ? 'VISIBLE' : 'HIDDEN' }}
                    </span>
                    <button
                        wire:click="toggleVisibility({{ $project->id }})"
                        class="relative w-9 h-5 rounded-full transition-colors duration-200 focus:outline-none border-0 cursor-pointer flex-shrink-0"
                        style="background: {{ $project->is_visible ? '#22d3ee' : '' }}"
                        class="{{ $project->is_visible ? 'bg-cyan-400' : 'bg-slate-200 dark:bg-navy-500' }}"
                    >
                        <span
                            class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"
                            style="transform: translateX({{ $project->is_visible ? '16px' : '2px' }})"
                        ></span>
                    </button>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    @endif

    {{-- ============================================================
         CREATE / EDIT MODAL
    ============================================================ --}}
    @if ($showModal)
    <div
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-data
        x-init="document.body.style.overflow = 'hidden'"
        x-on:keydown.escape.window="$wire.closeModal()"
    >
        {{-- Backdrop --}}
        <div
            class="absolute inset-0 bg-black/50 dark:bg-black/70"
            wire:click="closeModal"
        ></div>

        {{-- Modal Panel --}}
        <div class="relative w-full max-w-lg card p-6 shadow-2xl z-10">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-medium text-slate-800 dark:text-slate-100 font-mono">
                    {{ $editingId ? 'Edit Project' : 'New Project' }}
                </h2>
                <button wire:click="closeModal"
                    class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors text-lg leading-none cursor-pointer bg-transparent border-0">
                    ✕
                </button>
            </div>

            {{-- Form --}}
            <div class="space-y-4">

                {{-- Title --}}
                <div>
                    <label class="form-label">PROJECT TITLE *</label>
                    <input
                        wire:model="title"
                        type="text"
                        class="form-input"
                        placeholder="e.g. E-Commerce Platform"
                        autofocus
                    >
                    @error('title')
                        <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="form-label">DESCRIPTION</label>
                    <textarea
                        wire:model="description"
                        class="form-textarea"
                        rows="3"
                        placeholder="Brief description of the project..."
                    ></textarea>
                </div>

                {{-- Status --}}
                <div>
                    <label class="form-label">STATUS *</label>
                    <select wire:model="status" class="form-select">
                        <option value="wip">WIP — In Progress</option>
                        <option value="live">Live — Deployed</option>
                        <option value="hidden">Hidden — Draft</option>
                    </select>
                    @error('status')
                        <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tags --}}
                <div>
                    <label class="form-label">TAGS <span class="normal-case text-navy-300">(comma separated)</span></label>
                    <input
                        wire:model="tags"
                        type="text"
                        class="form-input"
                        placeholder="Laravel, MySQL, Vue.js"
                    >
                </div>

                {{-- URLs --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">LIVE URL</label>
                        <input
                            wire:model="live_url"
                            type="text"
                            class="form-input"
                            placeholder="https://..."
                        >
                        @error('live_url')
                            <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">REPO URL</label>
                        <input
                            wire:model="repo_url"
                            type="text"
                            class="form-input"
                            placeholder="https://gitlab.com/..."
                        >
                        @error('repo_url')
                            <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-slate-100 dark:border-navy-600">
                <button wire:click="closeModal" class="btn-ghost px-4 py-2 text-xs">Cancel</button>
                <button wire:click="save" wire:loading.attr="disabled" class="btn-primary">
                    <span wire:loading.remove wire:target="save">
                        {{ $editingId ? 'Update Project' : 'Create Project' }}
                    </span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>

        </div>
    </div>
    @endif

    {{-- ============================================================
         DELETE CONFIRM MODAL
    ============================================================ --}}
    @if ($showDelete)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 dark:bg-black/70" wire:click="closeModal"></div>
        <div class="relative w-full max-w-sm card p-6 shadow-2xl z-10">
            <h2 class="text-base font-medium text-slate-800 dark:text-slate-100 font-mono mb-2">Delete Project?</h2>
            <p class="text-xs text-slate-400 dark:text-navy-200 font-mono mb-6 leading-relaxed">
                This action is permanent and cannot be undone. The project will be removed from your portfolio.
            </p>
            <div class="flex justify-end gap-2">
                <button wire:click="closeModal" class="btn-ghost px-4 py-2 text-xs">Cancel</button>
                <button wire:click="delete" class="btn-delete px-4 py-2 text-xs font-semibold">
                    <span wire:loading.remove wire:target="delete">Yes, Delete</span>
                    <span wire:loading wire:target="delete">Deleting...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>

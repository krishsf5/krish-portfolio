<div>

    {{-- Header --}}
    <div class="flex items-end justify-between mb-6">
        <div></div>
        <button wire:click="create"
            class="bg-cyan-400 text-[#080a14] font-semibold text-xs px-4 py-2 rounded-lg border-0 cursor-pointer hover:bg-cyan-300 active:scale-95 transition-all font-mono">
            + New Project
        </button>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="mb-4 px-4 py-2.5 rounded-lg text-xs font-mono
                   bg-cyan-50 dark:bg-cyan-950/30
                   border border-cyan-200 dark:border-cyan-900/50
                   text-cyan-600 dark:text-cyan-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Empty State --}}
    @if ($projects->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
            <p class="text-sm font-mono text-slate-500 dark:text-slate-200 mb-1">No projects yet</p>
            <p class="text-xs font-mono text-slate-400 dark:text-slate-300">
                Click <span class="text-cyan-500 dark:text-cyan-300">+ New Project</span> to add your first one.
            </p>
        </div>
    @else
        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($projects as $project)
                <div class="card card-hover overflow-hidden flex flex-col">

                    {{-- Thumbnail --}}

                    <div class="relative">

                        @if ($project->thumbnail)
                            <img src="/storage/{{ $project->thumbnail }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-zinc-800 text-zinc-500 text-sm">
                                No Image
                            </div>
                        @endif


                        {{-- Status Badge --}}

                        <div class="absolute top-3 left-3">

                            @if ($project->status === 'live')
                                <span class="badge-live">LIVE</span>
                            @elseif($project->status === 'wip')
                                <span class="badge-wip">WIP</span>
                            @else
                                <span class="badge-hidden">HIDDEN</span>
                            @endif

                        </div>

                    </div>


                    {{-- Content --}}

                    <div class="p-6 flex flex-col gap-4 flex-1">

                        {{-- Title --}}

                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                            {{ $project->title }}
                        </h3>


                        {{-- Description --}}

                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                            {{ $project->description }}
                        </p>


                        {{-- Tags --}}

                        @if ($project->tags)
                            <div class="flex flex-wrap gap-2">

                                @foreach ($project->tags as $tag)
                                    <span
                                        class="px-2 py-1 text-xs rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">
                                        {{ $tag }}
                                    </span>
                                @endforeach

                            </div>
                        @endif


                        {{-- Divider --}}

                        <div class="border-t border-zinc-200 dark:border-zinc-700 mt-2"></div>


                        {{-- Actions --}}

                        <div class="flex items-center justify-between pt-2">

                            <div class="flex gap-2">

                                <button wire:click="edit({{ $project->id }})" class="btn-edit">
                                    Edit
                                </button>

                                <button wire:click="confirmDelete({{ $project->id }})" class="btn-delete">
                                    Delete
                                </button>

                            </div>


                            {{-- Visibility Toggle --}}

                            <button wire:click="toggleVisibility({{ $project->id }})"
                                class="p-2 rounded-md border border-zinc-700 hover:border-cyan-400 transition"
                                title="{{ $project->is_visible ? 'Hide project' : 'Show project' }}">

                                @if ($project->is_visible)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />

                                        <circle cx="12" cy="12" r="3" />

                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-500" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.584 10.587A3 3 0 0013.414 13.417" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 5.297A9.77 9.77 0 0112 4.5c6 0 9.75 7.5 9.75 7.5a16.633 16.633 0 01-2.004 3.157" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.53 6.53C4.64 8.006 3.43 9.85 2.25 12c0 0 3.75 7.5 9.75 7.5 1.39 0 2.65-.31 3.81-.82" />

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
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data
            x-on:keydown.escape.window="$wire.closeModal()">

            <div class="absolute inset-0 bg-black/60" wire:click="closeModal"></div>

            <div
                class="relative w-full max-w-lg z-10 rounded-xl border shadow-2xl p-6
                    bg-white dark:bg-[#0c1120]
                    border-slate-200 dark:border-[#19243a]">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-medium font-mono text-slate-800 dark:text-slate-100">
                        {{ $editingId ? 'Edit Project' : 'New Project' }}
                    </h2>
                    <button wire:click="closeModal"
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200
                               transition-colors text-lg leading-none cursor-pointer bg-transparent border-0">
                        X
                    </button>
                </div>

                <div class="space-y-4">

                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-300 mb-1.5">PROJECT
                            TITLE *</label>
                        <input wire:model="title" type="text" placeholder="e.g. E-Commerce Platform"
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                  bg-slate-50 dark:bg-[#080a14]
                                  border-slate-200 dark:border-[#19243a]
                                  text-slate-800 dark:text-slate-100
                                  placeholder-slate-400 dark:placeholder-slate-500
                                  focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                        @error('title')
                            <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-300 mb-1.5">DESCRIPTION</label>
                        <textarea wire:model="description" rows="3" placeholder="Brief description of the project..."
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none resize-none transition-all
                                     bg-slate-50 dark:bg-[#080a14]
                                     border-slate-200 dark:border-[#19243a]
                                     text-slate-800 dark:text-slate-100
                                     placeholder-slate-400 dark:placeholder-slate-500
                                     focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                    </textarea>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-300 mb-1.5">STATUS
                            *</label>
                        <select wire:model="status"
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none cursor-pointer transition-all
                                   bg-slate-50 dark:bg-[#080a14]
                                   border-slate-200 dark:border-[#19243a]
                                   text-slate-800 dark:text-slate-100
                                   focus:border-cyan-400/50">
                            <option value="wip">WIP - In Progress</option>
                            <option value="live">Live - Deployed</option>
                            <option value="hidden">Hidden - Draft</option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-300 mb-1.5">TAGS
                            (comma separated)</label>
                        <input wire:model="tags" type="text" placeholder="Laravel, MySQL, Vue.js"
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                  bg-slate-50 dark:bg-[#080a14]
                                  border-slate-200 dark:border-[#19243a]
                                  text-slate-800 dark:text-slate-100
                                  placeholder-slate-400 dark:placeholder-slate-500
                                  focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-300 mb-1.5">LIVE
                                URL</label>
                            <input wire:model="live_url" type="text" placeholder="https://..."
                                class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                      bg-slate-50 dark:bg-[#080a14]
                                      border-slate-200 dark:border-[#19243a]
                                      text-slate-800 dark:text-slate-100
                                      placeholder-slate-400 dark:placeholder-slate-500
                                      focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                            @error('live_url')
                                <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-300 mb-1.5">REPO
                                URL</label>
                            <input wire:model="repo_url" type="text" placeholder="https://gitlab.com/..."
                                class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                      bg-slate-50 dark:bg-[#080a14]
                                      border-slate-200 dark:border-[#19243a]
                                      text-slate-800 dark:text-slate-100
                                      placeholder-slate-400 dark:placeholder-slate-500
                                      focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                            @error('repo_url')
                                <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-slate-100 dark:border-white/5">
                    <button wire:click="closeModal"
                        class="text-slate-500 dark:text-slate-200 border border-slate-200 dark:border-white/10 text-xs px-4 py-2
                               rounded-lg bg-transparent hover:text-slate-700 dark:hover:text-white
                               hover:border-slate-400 transition-all cursor-pointer font-mono">
                        Cancel
                    </button>
                    <button wire:click="save" wire:loading.attr="disabled"
                        class="bg-cyan-400 text-[#080a14] font-semibold text-xs px-4 py-2 rounded-lg
                               border-0 cursor-pointer hover:bg-cyan-300 active:scale-95 transition-all font-mono
                               disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove
                            wire:target="save">{{ $editingId ? 'Update Project' : 'Create Project' }}</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- DELETE MODAL --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60" wire:click="closeModal"></div>
            <div
                class="relative w-full max-w-sm z-10 rounded-xl border shadow-2xl p-6
                    bg-white dark:bg-[#0c1120]
                    border-slate-200 dark:border-[#19243a]">
                <h2 class="text-base font-medium font-mono text-slate-800 dark:text-slate-100 mb-2">Delete Project?
                </h2>
                <p class="text-xs font-mono text-slate-500 dark:text-slate-200 leading-relaxed mb-6">
                    This is permanent and cannot be undone.
                </p>
                <div class="flex justify-end gap-2">
                    <button wire:click="closeModal"
                        class="text-slate-500 dark:text-slate-200 border border-slate-200 dark:border-white/10 text-xs px-4 py-2
                               rounded-lg bg-transparent hover:text-slate-700 dark:hover:text-white transition-all cursor-pointer font-mono">
                        Cancel
                    </button>
                    <button wire:click="delete" wire:loading.attr="disabled"
                        class="text-red-400 border border-red-400/30 text-xs px-4 py-2 rounded-lg
                               bg-transparent hover:bg-red-400/10 hover:border-red-400
                               transition-all cursor-pointer font-semibold font-mono">
                        <span wire:loading.remove wire:target="delete">Yes, Delete</span>
                        <span wire:loading wire:target="delete">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

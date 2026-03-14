<div>
    {{-- Flash --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="mb-4 px-4 py-2.5 rounded-lg text-xs font-mono
                   bg-cyan-50 dark:bg-cyan-950/30
                   border border-cyan-200 dark:border-cyan-900/50
                   text-cyan-600 dark:text-cyan-400">
            {{ session('success') }}
        </div>
    @endif

    {{-- Empty State --}}
    @if ($projects->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
            <p class="text-sm font-mono text-slate-400 dark:text-slate-500 mb-1">No projects yet</p>
            <p class="text-xs font-mono text-slate-300 dark:text-slate-600">
                Click <span class="text-cyan-500">+ New Project</span> to add your first one.
            </p>
        </div>
    @else
        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach ($projects as $project)
                <div
                    class="rounded-xl border transition-all p-4 flex flex-col gap-3
                    bg-white dark:bg-[#0c1120]
                    border-slate-200 dark:border-[#19243a]
                    hover:border-slate-300 dark:hover:border-cyan-900/50">

                    {{-- Status Badge --}}
                    <div>
                        @if ($project->status === 'live' && $project->is_visible)
                            <span
                                class="inline-flex items-center gap-1.5 text-[10px] font-mono tracking-widest px-2.5 py-1 rounded
                                 bg-cyan-50 dark:bg-cyan-950/20 text-cyan-600 dark:text-cyan-400
                                 border border-cyan-200 dark:border-cyan-900/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span> LIVE
                            </span>
                        @elseif ($project->status === 'wip')
                            <span
                                class="inline-flex items-center gap-1.5 text-[10px] font-mono tracking-widest px-2.5 py-1 rounded
                                 bg-orange-50 dark:bg-orange-950/20 text-orange-500 dark:text-orange-400
                                 border border-orange-200 dark:border-orange-900/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> WIP
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 text-[10px] font-mono tracking-widest px-2.5 py-1 rounded
                                 bg-slate-100 dark:bg-white/5 text-slate-400 dark:text-slate-500
                                 border border-slate-200 dark:border-white/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> HIDDEN
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h3 class="text-sm font-medium text-slate-800 dark:text-slate-100 leading-snug">
                        {{ $project->title }}
                    </h3>

                    {{-- Description --}}
                    @if ($project->description)
                        <p class="text-xs text-slate-400 dark:text-slate-500 leading-relaxed line-clamp-2">
                            {{ $project->description }}
                        </p>
                    @endif

                    {{-- Tags --}}
                    @if (!empty($project->tags))
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($project->tags as $tag)
                                <span
                                    class="text-[10px] font-mono px-2 py-0.5 rounded
                                     bg-slate-100 dark:bg-white/5
                                     text-slate-500 dark:text-slate-400
                                     border border-slate-200 dark:border-white/10">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Links --}}
                    @if ($project->live_url || $project->repo_url)
                        <div class="flex gap-3">
                            @if ($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank"
                                    class="text-[10px] font-mono text-cyan-500 dark:text-cyan-400 hover:underline">
                                    Live ↗
                                </a>
                            @endif
                            @if ($project->repo_url)
                                <a href="{{ $project->repo_url }}" target="_blank"
                                    class="text-[10px] font-mono text-slate-400 hover:underline">
                                    Repo ↗
                                </a>
                            @endif
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-2 border-t border-slate-100 dark:border-white/5 mt-auto">

                        {{-- Edit --}}
                        <button wire:click="edit({{ $project->id }})"
                            class="text-yellow-400 border border-yellow-400/30 text-[10px] px-2.5 py-1.5 rounded-md
                           bg-transparent hover:bg-yellow-400/10 hover:border-yellow-400
                           transition-all cursor-pointer font-semibold tracking-wide font-mono">
                            Edit
                        </button>

                        {{-- Delete --}}
                        <button wire:click="confirmDelete({{ $project->id }})"
                            class="text-red-400 border border-red-400/30 text-[10px] px-2.5 py-1.5 rounded-md
                           bg-transparent hover:bg-red-400/10 hover:border-red-400
                           transition-all cursor-pointer font-semibold tracking-wide font-mono">
                            Delete
                        </button>

                        {{-- Visibility Toggle --}}
                        <div class="flex items-center gap-2 ml-auto">
                            <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500">
                                {{ $project->is_visible ? 'VISIBLE' : 'HIDDEN' }}
                            </span>
                            <button wire:click="toggleVisibility({{ $project->id }})"
                                class="relative w-9 h-5 rounded-full border-0 cursor-pointer transition-colors duration-200 flex-shrink-0"
                                style="background: {{ $project->is_visible ? '#22d3ee' : '#334155' }}">
                                <span
                                    class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 block"
                                    style="transform: translateX({{ $project->is_visible ? '16px' : '2px' }})"></span>
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

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/60" wire:click="closeModal"></div>

            {{-- Panel --}}
            <div
                class="relative w-full max-w-lg z-10 rounded-xl border shadow-2xl p-6
                    bg-white dark:bg-[#0c1120]
                    border-slate-200 dark:border-[#19243a]">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-medium font-mono text-slate-800 dark:text-slate-100">
                        {{ $editingId ? 'Edit Project' : 'New Project' }}
                    </h2>
                    <button wire:click="closeModal"
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200
                               transition-colors text-lg leading-none cursor-pointer bg-transparent border-0">
                        ✕
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">

                        <label class="form-label">
                            Thumbnail
                        </label>

                        <input type="file" wire:model="thumbnail" class="form-input" />

                        @error('thumbnail')
                            <span class="text-red-500 text-xs">
                                {{ $message }}
                            </span>
                        @enderror

                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="w-40 rounded-lg mt-2" />
                        @endif

                    </div>

                    {{-- Title --}}
                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-500 mb-1.5">
                            PROJECT TITLE *
                        </label>
                        <input wire:model="title" type="text" placeholder="e.g. E-Commerce Platform"
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                  bg-slate-50 dark:bg-[#080a14]
                                  border-slate-200 dark:border-[#19243a]
                                  text-slate-800 dark:text-slate-200
                                  placeholder-slate-400 dark:placeholder-slate-600
                                  focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                        @error('title')
                            <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-500 mb-1.5">
                            DESCRIPTION
                        </label>
                        <textarea wire:model="description" rows="3" placeholder="Brief description of the project..."
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none resize-none transition-all
                                     bg-slate-50 dark:bg-[#080a14]
                                     border-slate-200 dark:border-[#19243a]
                                     text-slate-800 dark:text-slate-200
                                     placeholder-slate-400 dark:placeholder-slate-600
                                     focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                    </textarea>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-500 mb-1.5">
                            STATUS *
                        </label>
                        <select wire:model="status"
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none cursor-pointer transition-all
                                   bg-slate-50 dark:bg-[#080a14]
                                   border-slate-200 dark:border-[#19243a]
                                   text-slate-800 dark:text-slate-200
                                   focus:border-cyan-400/50">
                            <option value="wip">WIP — In Progress</option>
                            <option value="live">Live — Deployed</option>
                            <option value="hidden">Hidden — Draft</option>
                        </select>
                    </div>

                    {{-- Tags --}}
                    <div>
                        <label
                            class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-500 mb-1.5">
                            TAGS (comma separated)
                        </label>
                        <input wire:model="tags" type="text" placeholder="Laravel, MySQL, Vue.js"
                            class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                  bg-slate-50 dark:bg-[#080a14]
                                  border-slate-200 dark:border-[#19243a]
                                  text-slate-800 dark:text-slate-200
                                  placeholder-slate-400 dark:placeholder-slate-600
                                  focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                    </div>

                    {{-- URLs --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-500 mb-1.5">
                                LIVE URL
                            </label>
                            <input wire:model="live_url" type="text" placeholder="https://..."
                                class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                      bg-slate-50 dark:bg-[#080a14]
                                      border-slate-200 dark:border-[#19243a]
                                      text-slate-800 dark:text-slate-200
                                      placeholder-slate-400 dark:placeholder-slate-600
                                      focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                            @error('live_url')
                                <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-mono tracking-widest text-slate-400 dark:text-slate-500 mb-1.5">
                                REPO URL
                            </label>
                            <input wire:model="repo_url" type="text" placeholder="https://gitlab.com/..."
                                class="w-full rounded-lg border px-3 py-2 text-xs font-mono outline-none transition-all
                                      bg-slate-50 dark:bg-[#080a14]
                                      border-slate-200 dark:border-[#19243a]
                                      text-slate-800 dark:text-slate-200
                                      placeholder-slate-400 dark:placeholder-slate-600
                                      focus:border-cyan-400/50 focus:ring-1 focus:ring-cyan-400/30">
                            @error('repo_url')
                                <p class="text-[10px] text-red-400 font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-slate-100 dark:border-white/5">
                    <button wire:click="closeModal"
                        class="text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-white/10
                               text-xs px-4 py-2 rounded-lg bg-transparent hover:text-slate-600
                               dark:hover:text-slate-300 hover:border-slate-400 transition-all cursor-pointer font-mono">
                        Cancel
                    </button>
                    <button wire:click="save" wire:loading.attr="disabled"
                        class="bg-cyan-400 text-[#080a14] font-semibold text-xs px-4 py-2 rounded-lg
                               border-0 cursor-pointer hover:bg-cyan-300 active:scale-95 transition-all font-mono
                               disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="save">
                            {{ $editingId ? 'Update Project' : 'Create Project' }}
                        </span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- DELETE CONFIRM MODAL --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60" wire:click="closeModal"></div>
            <div
                class="relative w-full max-w-sm z-10 rounded-xl border shadow-2xl p-6
                    bg-white dark:bg-[#0c1120]
                    border-slate-200 dark:border-[#19243a]">
                <h2 class="text-base font-medium font-mono text-slate-800 dark:text-slate-100 mb-2">
                    Delete Project?
                </h2>
                <p class="text-xs font-mono text-slate-400 dark:text-slate-500 leading-relaxed mb-6">
                    This is permanent and cannot be undone. The project will be removed from your portfolio.
                </p>
                <div class="flex justify-end gap-2">
                    <button wire:click="closeModal"
                        class="text-slate-400 border border-slate-200 dark:border-white/10 text-xs px-4 py-2
                               rounded-lg bg-transparent hover:text-slate-600 transition-all cursor-pointer font-mono">
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

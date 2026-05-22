<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Project Manager</h2>
            <p class="text-sm text-slate-400 mt-1">Create, edit and manage portfolio projects</p>
        </div>
        <button wire:click="create" class="btn-primary flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            New Project
        </button>
    </div>


    {{-- FLASH --}}
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
                    <p class="text-xs text-slate-400 mt-1">Click <span class="text-cyan-400">New Project</span> to add your first one.</p>
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
                            <div class="w-full h-44 flex items-center justify-center bg-[#0c1120] text-slate-500 text-xs">No Image</div>
                        @endif

                        <div class="absolute inset-x-0 top-0 h-[3px]
                            @if ($project->status === 'live') bg-green-400
                            @elseif ($project->status === 'wip') bg-orange-400
                            @else bg-red-400 @endif">
                        </div>

                        <div class="absolute top-3 left-3">
                            @if ($project->status === 'live')
                                <span class="badge-live flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span> LIVE
                                </span>
                            @elseif ($project->status === 'wip')
                                <span class="badge-wip flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-orange-400"></span> WIP
                                </span>
                            @else
                                <span class="badge-hidden flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-red-400"></span> HIDDEN
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- CARD CONTENT --}}
                    <div class="p-6 flex flex-col gap-4 flex-1">
                        <h3 class="text-lg font-semibold text-white">{{ $project->title }}</h3>
                        <p class="text-sm text-slate-400 line-clamp-2">{!! strip_tags($project->description) !!}</p>

                        @if ($project->tags)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($project->tags as $tag)
                                    <span class="px-2 py-1 text-xs rounded bg-[#080a14] border border-[#19243a] text-slate-300">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($project->start_date)
                            <p class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }}
                                @if ($project->end_date)
                                    → {{ \Carbon\Carbon::parse($project->end_date)->format('M Y') }}
                                @else
                                    → Present
                                @endif
                            </p>
                        @endif

                        <div class="divider"></div>

                        <div class="flex items-center justify-between">
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $project->id }})" class="btn-edit">Edit</button>
                                <button wire:click="confirmDelete({{ $project->id }})" class="btn-delete">Delete</button>
                            </div>
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


    {{-- ============================================================
         CREATE / EDIT MODAL — redesigned to match Edit Entry style
    ============================================================ --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
             x-data x-on:keydown.escape.window="$wire.closeModal()">

            <div class="w-full max-w-2xl max-h-[92vh] overflow-y-auto rounded-2xl bg-[#0d1526] border border-[#1e2d45] shadow-2xl flex flex-col">

                {{-- ── MODAL HEADER ── --}}
                <div class="flex items-center justify-between px-7 py-5 border-b border-[#1e2d45]">
                    <h3 class="text-base font-bold text-white tracking-tight">
                        {{ $editingId ? 'Edit Project' : 'New Project' }}
                    </h3>

                    <div class="flex items-center gap-1">

                        {{-- Status selector as icon row --}}
                        <div class="flex items-center gap-1 mr-3">
                            <button wire:click="$set('status', 'live')"
                                title="Live"
                                class="px-2.5 py-1 rounded text-xs font-mono transition
                                    {{ $status === 'live' ? 'bg-green-400/15 text-green-400 border border-green-400/30' : 'text-slate-500 hover:text-green-400' }}">
                                LIVE
                            </button>
                            <button wire:click="$set('status', 'wip')"
                                title="WIP"
                                class="px-2.5 py-1 rounded text-xs font-mono transition
                                    {{ $status === 'wip' ? 'bg-orange-400/15 text-orange-400 border border-orange-400/30' : 'text-slate-500 hover:text-orange-400' }}">
                                WIP
                            </button>
                            <button wire:click="$set('status', 'hidden')"
                                title="Hidden"
                                class="px-2.5 py-1 rounded text-xs font-mono transition
                                    {{ $status === 'hidden' ? 'bg-red-400/15 text-red-400 border border-red-400/30' : 'text-slate-500 hover:text-red-400' }}">
                                HIDDEN
                            </button>
                        </div>

                        {{-- Visibility toggle --}}
                        @if ($editingId)
                            @php $proj = \App\Models\Project::find($editingId); @endphp
                            <button wire:click="toggleVisibility({{ $editingId }})"
                                title="{{ $proj?->is_visible ? 'Hide' : 'Show' }}"
                                class="p-2 rounded-lg text-slate-500 hover:text-cyan-400 hover:bg-cyan-400/10 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        @endif

                        {{-- Delete --}}
                        @if ($editingId)
                            <button wire:click="confirmDelete({{ $editingId }})"
                                title="Delete project"
                                class="p-2 rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-400/10 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif

                        {{-- Close --}}
                        <button wire:click="closeModal"
                            class="p-2 rounded-lg text-slate-500 hover:text-white hover:bg-white/10 transition ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>


                {{-- ── FORM BODY ── --}}
                <div class="px-7 py-6 space-y-5 flex-1">

                    {{-- PROJECT TITLE + LIVE URL --}}
                    <div>
                        <label class="form-label">Project title <span class="text-red-400">*</span></label>
                        <div class="flex gap-2">
                            <input wire:model.defer="title"
                                type="text"
                                placeholder="E-Commerce Platform"
                                class="form-input flex-1">
                            <div class="relative flex-shrink-0">
                                <input wire:model.defer="live_url"
                                    type="text"
                                    placeholder="https://..."
                                    class="form-input w-44 pl-8 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-500 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                        </div>
                        @error('title') <p class="form-error">{{ $message }}</p> @enderror
                        @error('live_url') <p class="form-error">{{ $message }}</p> @enderror
                    </div>


                    {{-- SUBTITLE / TAGS + REPO URL --}}
                    <div>
                        <label class="form-label">Sub title / Tags</label>
                        <div class="flex gap-2">
                            <input wire:model.defer="tags"
                                type="text"
                                placeholder="Laravel, MySQL, Alpine.js"
                                class="form-input flex-1">
                            <div class="relative flex-shrink-0">
                                <input wire:model.defer="repo_url"
                                    type="text"
                                    placeholder="Repo URL"
                                    class="form-input w-44 pl-8 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-500 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                        </div>
                        @error('tags') <p class="form-error">{{ $message }}</p> @enderror
                    </div>


                    {{-- START DATE / END DATE --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Start Date</label>
                            <input wire:model.defer="start_date"
                                type="month"
                                class="form-input">
                            @error('start_date') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">End Date</label>
                            <input wire:model.defer="end_date"
                                type="month"
                                class="form-input">
                            @error('end_date') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>


                    {{-- DESCRIPTION — TRIX EDITOR --}}
                    <div
                        x-data="{
                            init() {
                                // Push existing value into trix on open
                                this.$nextTick(() => {
                                    const editor = this.$refs.trix;
                                    if (editor && @js($description)) {
                                        editor.editor.loadHTML(@js($description));
                                    }
                                });
                            }
                        }"
                    >
                        <label class="form-label">Description</label>

                        {{-- Trix hidden input --}}
                        <input id="trix-description-input"
                            type="hidden"
                            value="{{ $description }}">

                        {{-- Trix editor, wired to Livewire via Alpine --}}
                        <div wire:ignore class="trix-wrapper">
                            <trix-editor
                                x-ref="trix"
                                input="trix-description-input"
                                x-on:trix-change="$wire.set('description', $event.target.value)"
                                class="trix-editor-custom"
                                placeholder="What does this project do? Key features, tech choices, impact..."
                            ></trix-editor>
                        </div>

                        @error('description') <p class="form-error">{{ $message }}</p> @enderror

                        {{-- AI QUICK ACTIONS --}}
                        <div class="flex items-center gap-2 flex-wrap mt-3">
                            <span class="text-slate-600 text-xs">✦</span>
                            <button type="button" wire:click="improveWriting"
                                class="ai-action-btn">Improve Writing</button>
                            <button type="button" wire:click="suggestContent"
                                class="ai-action-btn">Suggest Content</button>
                            <button type="button" wire:click="grammarCheck"
                                class="ai-action-btn">Grammar Check</button>
                            <button type="button" wire:click="makeShorter"
                                class="ai-action-btn">Shorter</button>
                        </div>
                    </div>


                    {{-- THUMBNAIL --}}
                    <div>
                        <label class="form-label">Thumbnail</label>
                        <input wire:model="thumbnail"
                            type="file"
                            accept="image/*"
                            class="w-full text-sm text-slate-400
                                   file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                                   file:bg-cyan-400/10 file:text-cyan-400 file:text-xs
                                   hover:file:bg-cyan-400/20 transition cursor-pointer">
                        @error('thumbnail') <p class="form-error">{{ $message }}</p> @enderror

                        @if ($editingId && !$thumbnail)
                            @php $existingThumb = \App\Models\Project::find($editingId)?->thumbnail; @endphp
                            @if ($existingThumb)
                                <img src="/storage/{{ $existingThumb }}" class="mt-2 h-20 rounded-lg object-cover border border-[#1e2d45]">
                            @endif
                        @endif
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="mt-2 h-20 rounded-lg object-cover border border-[#1e2d45]">
                        @endif
                    </div>

                </div>


                {{-- ── MODAL FOOTER ── --}}
                <div class="flex items-center justify-end gap-3 px-7 py-4 border-t border-[#1e2d45]">
                    <button wire:click="closeModal" class="btn-ghost px-5 py-2 text-sm">Cancel</button>
                    <button wire:click="save" class="btn-primary px-6 py-2 text-sm">
                        {{ $editingId ? 'Update Project' : 'Create Project' }}
                    </button>
                </div>

            </div>
        </div>
    @endif


    {{-- DELETE CONFIRM --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
            <div class="w-full max-w-sm rounded-2xl bg-[#0d1526] border border-[#1e2d45] p-8 space-y-6 text-center shadow-2xl">
                <div class="w-12 h-12 rounded-full bg-red-400/10 border border-red-400/20 flex items-center justify-center mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Delete Project?</h3>
                    <p class="text-sm text-slate-400 mt-1">This cannot be undone. The thumbnail will also be deleted.</p>
                </div>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeModal" class="btn-ghost px-5 py-2 text-sm">Cancel</button>
                    <button wire:click="delete" class="btn-delete px-5 py-2 text-sm">Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>

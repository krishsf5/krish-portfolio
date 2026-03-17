<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Skills</h2>
            <p class="text-sm text-slate-400 mt-1">Tech stack shown on the public portfolio</p>
        </div>
        <button wire:click="create" class="btn-primary flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Skill
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
    @if ($skills->isEmpty())
        <div class="card p-16 text-center">
            <p class="text-sm text-slate-400">No skills yet. Click <span class="text-cyan-400">Add Skill</span> to get started.</p>
        </div>
    @else

        {{-- CATEGORY GROUPS --}}
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach (['Frontend', 'Backend', 'Database', 'Tools'] as $category)
                <div class="card p-5 space-y-3">

                    <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400 mb-4">
                        {{ $category }}
                    </h3>

                    @forelse ($skills->get($category, collect()) as $skill)
                        <div class="flex items-center justify-between gap-2 p-3 rounded-lg border border-slate-700/50 bg-[#080a14] group">

                            {{-- ICON + NAME --}}
                            <div class="flex items-center gap-3 min-w-0">
                                @if ($skill->icon)
                                    <i class="{{ $skill->icon }} text-xl text-cyan-400 shrink-0"></i>
                                @else
                                    <span class="w-5 h-5 rounded bg-slate-700 shrink-0"></span>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm text-slate-200 truncate">{{ $skill->name }}</p>
                                    <div class="flex gap-0.5 mt-1">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <span class="h-1 w-3 rounded-full {{ $i <= $skill->proficiency ? 'bg-cyan-400' : 'bg-slate-700' }}"></span>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="flex items-center gap-1 shrink-0">

                                {{-- MOVE UP --}}
                                <button wire:click="moveUp({{ $skill->id }})"
                                    class="p-1 text-slate-500 hover:text-cyan-400 transition"
                                    title="Move up">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                                    </svg>
                                </button>

                                {{-- MOVE DOWN --}}
                                <button wire:click="moveDown({{ $skill->id }})"
                                    class="p-1 text-slate-500 hover:text-cyan-400 transition"
                                    title="Move down">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                {{-- VISIBILITY --}}
                                <button wire:click="toggleVisibility({{ $skill->id }})"
                                    class="p-1 transition"
                                    title="{{ $skill->is_visible ? 'Hide' : 'Show' }}">
                                    @if ($skill->is_visible)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                                        </svg>
                                    @endif
                                </button>

                                {{-- EDIT --}}
                                <button wire:click="edit({{ $skill->id }})"
                                    class="p-1 text-yellow-400 hover:text-yellow-300 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 1 1 3.182 3.182L7.5 19.213l-4.5 1.318 1.318-4.5 12.544-12.544z"/>
                                    </svg>
                                </button>

                                {{-- DELETE --}}
                                <button wire:click="confirmDelete({{ $skill->id }})"
                                    class="p-1 text-red-400 hover:text-red-300 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>

                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-600 py-4 text-center">No skills in this category</p>
                    @endforelse

                </div>
            @endforeach
        </div>

    @endif


    {{-- CREATE / EDIT MODAL --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
             x-data x-on:keydown.escape.window="$wire.closeModal()">

            <div class="card w-full max-w-md p-8 space-y-6 shadow-2xl">

                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white">
                        {{ $editingId ? 'Edit Skill' : 'Add Skill' }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">

                    {{-- NAME --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Name *</label>
                        <input wire:model="name" type="text" placeholder="e.g. Laravel"
                            class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                        @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- CATEGORY --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Category *</label>
                        <select wire:model="category"
                            class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 focus:border-cyan-400 focus:outline-none transition">
                            @foreach (['Frontend', 'Backend', 'Database', 'Tools'] as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- ICON --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">
                            Devicon Class
                            <a href="https://devicon.dev" target="_blank" class="text-cyan-400 normal-case ml-1">(browse icons)</a>
                        </label>
                        <div class="flex items-center gap-3">
                            <input wire:model.live="icon" type="text" placeholder="e.g. devicon-laravel-plain"
                                class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                            @if ($icon)
                                <i class="{{ $icon }} text-2xl text-cyan-400 shrink-0"></i>
                            @endif
                        </div>
                        @error('icon') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- PROFICIENCY --}}
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">
                            Proficiency: <span class="text-cyan-400">{{ $proficiency }}/10</span>
                        </label>
                        <input wire:model.live="proficiency" type="range" min="1" max="10"
                            class="w-full accent-cyan-400">
                        <div class="flex gap-0.5 mt-2">
                            @for ($i = 1; $i <= 10; $i++)
                                <span class="h-1.5 flex-1 rounded-full {{ $i <= $proficiency ? 'bg-cyan-400' : 'bg-slate-700' }}"></span>
                            @endfor
                        </div>
                        @error('proficiency') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- VISIBLE --}}
                    <div class="flex items-center gap-3">
                        <input wire:model="is_visible" type="checkbox" id="skill-visible"
                            class="w-4 h-4 accent-cyan-400 rounded">
                        <label for="skill-visible" class="text-sm text-slate-300">Visible on portfolio</label>
                    </div>

                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button wire:click="closeModal" class="btn-ghost px-5 py-2">Cancel</button>
                    <button wire:click="save" class="btn-primary px-5 py-2">
                        {{ $editingId ? 'Update' : 'Add Skill' }}
                    </button>
                </div>

            </div>
        </div>
    @endif


    {{-- DELETE CONFIRM --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="card w-full max-w-sm p-8 space-y-6 text-center">
                <h3 class="text-lg font-bold text-white">Delete Skill?</h3>
                <p class="text-sm text-slate-400">This cannot be undone.</p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeModal" class="btn-ghost px-5 py-2">Cancel</button>
                    <button wire:click="delete" class="btn-delete px-5 py-2">Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>

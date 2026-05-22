<div class="max-w-3xl space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">About Me</h2>
            <p class="text-sm text-slate-400 mt-1">Your public profile shown on the portfolio</p>
        </div>
        <button wire:click="save" class="btn-primary">Save Changes</button>
    </div>


    {{-- FLASH --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="px-4 py-3 rounded-lg text-xs font-mono border border-cyan-400/20 bg-cyan-400/10 text-cyan-300">
            {{ session('success') }}
        </div>
    @endif


    {{-- AVATAR --}}
    <div class="card p-6 space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">Photo</h3>

        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 shrink-0">
                @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                @elseif ($existingAvatar)
                    <img src="{{ asset('storage/' . $existingAvatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-600 text-xs">No photo</div>
                @endif
            </div>
            <div>
                <label class="btn-ghost px-4 py-2 cursor-pointer inline-block">
                    Choose Photo
                    <input wire:model="avatar" type="file" accept="image/*" class="hidden">
                </label>
                <p class="text-xs text-slate-500 mt-2">PNG, JPG, WEBP · Max 2MB</p>
                @error('avatar')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>


    {{-- BASIC INFO --}}
    <div class="card p-6 space-y-5">
        <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">Basic Info</h3>

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Full Name
                    *</label>
                <input wire:model="full_name" type="text" placeholder="Krish Bhojwani"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                @error('full_name')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Title *</label>
                <input wire:model="title" type="text" placeholder="Software Engineer"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                @error('title')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Location</label>
                <input wire:model="location" type="text" placeholder="Mumbai, India"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Email</label>
                <input wire:model="email" type="email" placeholder="you@email.com"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                @error('email')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Years
                    Experience</label>
                <input wire:model="years_experience" type="number" min="0" max="50"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 focus:border-cyan-400 focus:outline-none transition">
            </div>

            <div>
                <label
                    class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Availability</label>
                <select wire:model="availability"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 focus:border-cyan-400 focus:outline-none transition">
                    <option value="available">Available for work</option>
                    <option value="open">Open to opportunities</option>
                    <option value="unavailable">Not available</option>
                </select>
            </div>

        </div>

        <div>
            <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Bio</label>
            <textarea wire:model="bio" rows="4" placeholder="Write a short bio..."
                class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition resize-y"></textarea>
        </div>
    </div>


    {{-- STATS --}}
    <div class="card p-6 space-y-5">

        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">Stats</h3>
                <p class="text-xs text-slate-500 mt-1">Shown as highlight cards on your about section</p>
            </div>
            <button wire:click="addStat" class="btn-ghost px-3 py-1.5 text-xs flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add Stat
            </button>
        </div>

        {{-- AUTO STAT — always shown, not editable --}}
        <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-700/50 bg-[#080a14]">
            <div class="flex-1 grid grid-cols-2 gap-3">
                <div>
                    <p class="text-xs text-slate-500 mb-1">Label</p>
                    <p class="text-sm text-slate-300 px-3 py-2 rounded-lg bg-slate-800/50 border border-slate-700">
                        Projects Built</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Value</p>
                    <p
                        class="text-sm text-cyan-400 font-bold px-3 py-2 rounded-lg bg-slate-800/50 border border-slate-700">
                        {{ $liveProjectCount }}
                    </p>
                </div>
            </div>
            <div class="shrink-0 w-7">
                <span class="text-xs text-slate-600 font-mono">auto</span>
            </div>
        </div>

        {{-- CUSTOM STATS --}}
        @forelse ($stats as $index => $stat)
            <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-700/50 bg-[#080a14]">

                <div class="flex-1 grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Label</p>
                        <input wire:model="stats.{{ $index }}.label" type="text" placeholder="Technologies"
                            class="w-full px-3 py-2 rounded-lg bg-[#0c1120] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition text-sm">
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Value</p>
                        <input wire:model="stats.{{ $index }}.value" type="text" placeholder="5+"
                            class="w-full px-3 py-2 rounded-lg bg-[#0c1120] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition text-sm">
                    </div>
                </div>

                <button wire:click="removeStat({{ $index }})"
                    class="shrink-0 p-1.5 text-slate-600 hover:text-red-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        @empty
            <p class="text-xs text-slate-600 text-center py-3">
                No custom stats yet. Click <span class="text-cyan-400">Add Stat</span> to add one.
            </p>
        @endforelse

    </div>


    {{-- LINKS --}}
    <div class="card p-6 space-y-5">
        <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">Social Links</h3>

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">GitHub / GitLab
                    URL</label>
                <input wire:model="github_url" type="text" placeholder="https://gitlab.com/username"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                @error('github_url')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">LinkedIn
                    URL</label>
                <input wire:model="linkedin_url" type="text" placeholder="https://linkedin.com/in/username"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                @error('linkedin_url')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold uppercase tracking-wider text-slate-400 block mb-1">Website
                    URL</label>
                <input wire:model="website_url" type="text" placeholder="https://yoursite.com"
                    class="w-full px-3 py-2 rounded-lg bg-[#080a14] border border-slate-700 text-slate-100 placeholder:text-slate-600 focus:border-cyan-400 focus:outline-none transition">
                @error('website_url')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>


    {{-- SAVE --}}
    <div class="flex justify-end pb-8">
        <button wire:click="save" class="btn-primary px-8 py-3 text-sm">
            Save Changes
        </button>
    </div>

</div>

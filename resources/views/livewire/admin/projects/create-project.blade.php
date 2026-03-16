<div class="dashboard">
    <div class="mx-auto flex flex-col gap-8 animate-[slideUp_0.4s_cubic-bezier(0.22,1,0.36,1)_both]">


        {{-- ── HEADER ── --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-[1.75rem] font-bold tracking-tight leading-tight text-slate-900 dark:text-slate-100">
                    Create Project
                </h1>
                <p class="mt-1.5  text-slate-500 dark:text-slate-400">
                    Configure a new project that will appear on your portfolio.
                </p>
            </div>
        </div>


        {{-- ── MAIN CARD ── --}}
        <div
            class="bg-white dark:bg-gray-900 border border-black/[0.08] dark:border-white/[0.07] rounded-2xl shadow-sm overflow-hidden">


            {{-- ── BASIC INFORMATION ── --}}
            <div class="p-8">

                <div class="flex items-center gap-2.5 mb-6">
                    <div
                        class="w-7 h-7 rounded-lg bg-sky-500/[0.07] dark:bg-sky-400/[0.06] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-sky-500 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                    </div>
                    <span class="text-[0.7rem] font-bold tracking-[0.1em] uppercase text-slate-500 dark:text-[#7c8ea8]">
                        Basic Information
                    </span>
                </div>

                <div class="flex flex-col gap-5">

                    {{-- Title --}}
                    <div class="flex flex-col gap-1">
                        <label
                            class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8] flex items-center gap-1">
                            Project Title <span class="text-sky-500 dark:text-sky-400 text-[0.85em]">*</span>
                        </label>
                        <div class="relative group">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-[15px] h-[15px] text-slate-400 dark:text-slate-600 pointer-events-none transition-colors group-focus-within:text-sky-500 dark:group-focus-within:text-sky-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 7 4 4 20 4 20 7" />
                                <line x1="9" y1="20" x2="15" y2="20" />
                                <line x1="12" y1="4" x2="12" y2="20" />
                            </svg>
                            <input wire:model="title" type="text" placeholder="E-Commerce Platform"
                                class="w-full pl-9 pr-3.5 py-2.5  rounded-lg bg-slate-100 dark:bg-[#1a2335] border border-transparent text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-600 outline-none transition-all hover:border-black/[0.08] dark:hover:border-white/[0.07] hover:bg-white dark:hover:bg-[#1e2a40] focus:border-sky-500 dark:focus:border-sky-400 focus:bg-white dark:focus:bg-[#1e2a40] focus:ring-3 focus:ring-sky-500/[0.18] dark:focus:ring-sky-400/[0.15]">
                        </div>
                        <span class="text-[0.7rem] text-slate-400 dark:text-slate-600">A clear, concise name for the
                            project.</span>
                        @error('title')
                            <span
                                class="text-[0.7rem] text-red-500 dark:text-red-400 bg-red-500/[0.06] dark:bg-red-400/[0.07] px-2 py-1 rounded-lg border-l-2 border-red-500 dark:border-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8]">
                            Description
                        </label>
                        <textarea wire:model="description" rows="3"
                            placeholder="Describe what this project does and what problems it solves…"
                            class="w-full px-3.5 py-2.5  rounded-lg bg-slate-100 dark:bg-[#1a2335] border border-transparent text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-600 outline-none transition-all resize-y min-h-[90px] hover:border-black/[0.08] dark:hover:border-white/[0.07] hover:bg-white dark:hover:bg-[#1e2a40] focus:border-sky-500 dark:focus:border-sky-400 focus:bg-white dark:focus:bg-[#1e2a40] focus:ring-3 focus:ring-sky-500/[0.18] dark:focus:ring-sky-400/[0.15]"></textarea>
                        <span class="text-[0.7rem] text-slate-400 dark:text-slate-600">Short summary displayed on your
                            portfolio.</span>
                    </div>

                </div>
            </div>


            {{-- ── THUMBNAIL ── --}}
            <div class="p-8 border-t border-black/[0.06] dark:border-white/[0.05]">

                <div class="flex items-center gap-2.5 mb-6">
                    <div
                        class="w-7 h-7 rounded-lg bg-sky-500/[0.07] dark:bg-sky-400/[0.06] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-sky-500 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <polyline points="21 15 16 10 5 21" />
                        </svg>
                    </div>
                    <span class="text-[0.7rem] font-bold tracking-[0.1em] uppercase text-slate-500 dark:text-[#7c8ea8]">
                        Thumbnail
                    </span>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8]">
                        Project Thumbnail
                    </label>

                    <div id="thumb-zone"
                        class="thumb-zone relative border-[1.5px] border-dashed border-black/[0.12] dark:border-white/[0.1] rounded-xl bg-slate-100 dark:bg-[#1a2335] cursor-pointer overflow-hidden transition-all hover:border-sky-500 dark:hover:border-sky-400 hover:bg-sky-500/[0.04] dark:hover:bg-sky-400/[0.04]"
                        ondragover="thumbDragOver(event)" ondragleave="thumbDragLeave(event)" ondrop="thumbDrop(event)">

                        <input wire:model="thumbnail" type="file" id="thumb-input"
                            accept="image/png,image/jpeg,image/webp,image/gif" onchange="thumbPreview(this)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                        {{-- Empty state --}}
                        <div id="thumb-empty"
                            class="flex flex-col items-center justify-center gap-2 px-4 py-9 text-center pointer-events-none">
                            <div
                                class="w-9 h-9 rounded-lg bg-sky-500/[0.07] dark:bg-sky-400/[0.06] flex items-center justify-center mb-1">
                                <svg class="w-[18px] h-[18px] text-sky-500 dark:text-sky-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                            </div>
                            <span class="text-[0.8rem] font-semibold text-slate-700 dark:text-slate-300">
                                Drop an image or click to browse
                            </span>
                            <span class="text-[0.7rem] text-slate-400 dark:text-slate-600 leading-snug">
                                PNG, JPG, WEBP · Max 2 MB · Recommended 1280×720
                            </span>
                            <span
                                class="inline-flex items-center gap-1 text-[0.65rem] font-bold tracking-[0.06em] uppercase px-2.5 py-1 rounded-full bg-sky-500/[0.07] dark:bg-sky-400/[0.06] text-sky-600 dark:text-sky-400 border border-sky-500/[0.18] dark:border-sky-400/[0.15] mt-1">
                                <svg class="w-[9px] h-[9px]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <polyline points="16 16 12 12 8 16" />
                                    <line x1="12" y1="12" x2="12" y2="21" />
                                    <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3" />
                                </svg>
                                Upload
                            </span>
                        </div>

                        {{-- Preview state --}}
                        <div id="thumb-preview" class="hidden relative">
                            <img id="thumb-img" src="" alt="Thumbnail preview"
                                class="w-full h-[200px] object-cover block">
                            <div
                                class="absolute bottom-0 left-0 right-0 px-3 py-2.5 bg-gradient-to-t from-black/65 to-transparent flex items-center justify-between gap-2">
                                <span id="thumb-fname"
                                    class="text-[0.7rem] font-semibold text-white truncate max-w-[calc(100%-80px)]"></span>
                                <button type="button" onclick="thumbClear(event)"
                                    class="shrink-0 text-[0.65rem] font-bold tracking-[0.05em] uppercase px-2.5 py-1 rounded-full border border-white/40 bg-white/10 text-white cursor-pointer transition-all hover:bg-red-500/70 hover:border-transparent">
                                    Remove
                                </button>
                            </div>
                        </div>

                    </div>

                    <span class="text-[0.7rem] text-slate-400 dark:text-slate-600">Displayed as the project card image
                        on your portfolio.</span>

                    @error('thumbnail')
                        <span
                            class="text-[0.7rem] text-red-500 dark:text-red-400 bg-red-500/[0.06] dark:bg-red-400/[0.07] px-2 py-1 rounded-lg border-l-2 border-red-500 dark:border-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            {{-- ── PROJECT SETTINGS ── --}}
            <div class="p-8 border-t border-black/[0.06] dark:border-white/[0.05]">

                <div class="flex items-center gap-2.5 mb-6">
                    <div
                        class="w-7 h-7 rounded-lg bg-sky-500/[0.07] dark:bg-sky-400/[0.06] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-sky-500 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
                        </svg>
                    </div>
                    <span
                        class="text-[0.7rem] font-bold tracking-[0.1em] uppercase text-slate-500 dark:text-[#7c8ea8]">
                        Project Settings
                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-5">

                    {{-- Status --}}
                    <div class="flex flex-col gap-1">
                        <label
                            class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8]">Status</label>
                        <div class="select-wrap relative">
                            <select wire:model="status" id="status-select" onchange="updateStatusBadge(this)"
                                class="w-full appearance-none px-3.5 pr-9 py-2.5  rounded-lg bg-slate-100 dark:bg-[#1a2335] border border-transparent text-slate-900 dark:text-slate-100 outline-none cursor-pointer transition-all hover:border-black/[0.08] dark:hover:border-white/[0.07] hover:bg-white dark:hover:bg-[#1e2a40] focus:border-sky-500 dark:focus:border-sky-400 focus:bg-white dark:focus:bg-[#1e2a40] focus:ring-3 focus:ring-sky-500/[0.18] dark:focus:ring-sky-400/[0.15]">
                                <option value="wip">WIP – Work in progress</option>
                                <option value="live">Live – Deployed</option>
                                <option value="hidden">Hidden – Draft</option>
                            </select>
                        </div>
                        <div id="status-badge"
                            class="inline-flex items-center gap-1.5 text-[0.7rem] font-semibold text-amber-600 dark:text-amber-400 mt-0.5">
                            <span id="status-dot" class="w-[7px] h-[7px] rounded-full bg-amber-400 shrink-0"></span>
                            <span id="status-label">Work in progress</span>
                        </div>
                    </div>

                    {{-- Tags --}}
                    <div class="flex flex-col gap-1">
                        <label
                            class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8]">Tags</label>
                        <div class="relative group">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-[15px] h-[15px] text-slate-400 dark:text-slate-600 pointer-events-none transition-colors group-focus-within:text-sky-500 dark:group-focus-within:text-sky-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                <line x1="7" y1="7" x2="7.01" y2="7" />
                            </svg>
                            <input wire:model="tags" type="text" id="tags-input"
                                placeholder="Laravel, MySQL, Alpine.js" oninput="renderTags(this.value)"
                                class="w-full pl-9 pr-3.5 py-2.5  rounded-lg bg-slate-100 dark:bg-[#1a2335] border border-transparent text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-600 outline-none transition-all hover:border-black/[0.08] dark:hover:border-white/[0.07] hover:bg-white dark:hover:bg-[#1e2a40] focus:border-sky-500 dark:focus:border-sky-400 focus:bg-white dark:focus:bg-[#1e2a40] focus:ring-3 focus:ring-sky-500/[0.18] dark:focus:ring-sky-400/[0.15]">
                        </div>
                        <div id="tags-preview" class="flex flex-wrap gap-1.5 mt-0.5"></div>
                        <span class="text-[0.7rem] text-slate-400 dark:text-slate-600">Comma-separated list of
                            technologies used.</span>
                    </div>

                </div>
            </div>


            {{-- ── PROJECT LINKS ── --}}
            <div class="p-8 border-t border-black/[0.06] dark:border-white/[0.05]">

                <div class="flex items-center gap-2.5 mb-6">
                    <div
                        class="w-7 h-7 rounded-lg bg-sky-500/[0.07] dark:bg-sky-400/[0.06] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-sky-500 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                        </svg>
                    </div>
                    <span
                        class="text-[0.7rem] font-bold tracking-[0.1em] uppercase text-slate-500 dark:text-[#7c8ea8]">
                        Project Links
                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-5">

                    {{-- Live URL --}}
                    <div class="flex flex-col gap-1">
                        <label
                            class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8]">Live
                            URL</label>
                        <div class="relative group">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-[15px] h-[15px] text-slate-400 dark:text-slate-600 pointer-events-none transition-colors group-focus-within:text-sky-500 dark:group-focus-within:text-sky-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                            <input wire:model="live_url" type="text" placeholder="https://your-project.com"
                                class="w-full pl-9 pr-3.5 py-2.5  rounded-lg bg-slate-100 dark:bg-[#1a2335] border border-transparent text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-600 outline-none transition-all hover:border-black/[0.08] dark:hover:border-white/[0.07] hover:bg-white dark:hover:bg-[#1e2a40] focus:border-sky-500 dark:focus:border-sky-400 focus:bg-white dark:focus:bg-[#1e2a40] focus:ring-3 focus:ring-sky-500/[0.18] dark:focus:ring-sky-400/[0.15]">
                        </div>
                        <span class="text-[0.7rem] text-slate-400 dark:text-slate-600">Where the project is deployed
                            publicly.</span>
                    </div>

                    {{-- Repo URL --}}
                    <div class="flex flex-col gap-1">
                        <label
                            class="text-[0.75rem] font-semibold tracking-wide text-slate-500 dark:text-[#7c8ea8]">Repository
                            URL</label>
                        <div class="relative group">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-[15px] h-[15px] text-slate-400 dark:text-slate-600 pointer-events-none transition-colors group-focus-within:text-sky-500 dark:group-focus-within:text-sky-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                            </svg>
                            <input wire:model="repo_url" type="text"
                                placeholder="https://github.com/username/project"
                                class="w-full pl-9 pr-3.5 py-2.5  rounded-lg bg-slate-100 dark:bg-[#1a2335] border border-transparent text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-600 outline-none transition-all hover:border-black/[0.08] dark:hover:border-white/[0.07] hover:bg-white dark:hover:bg-[#1e2a40] focus:border-sky-500 dark:focus:border-sky-400 focus:bg-white dark:focus:bg-[#1e2a40] focus:ring-3 focus:ring-sky-500/[0.18] dark:focus:ring-sky-400/[0.15]">
                        </div>
                        <span class="text-[0.7rem] text-slate-400 dark:text-slate-600">Source code repository (GitHub,
                            GitLab, etc.).</span>
                    </div>

                </div>
            </div>


            {{-- ── ACTION BAR ── --}}
            <div
                class="flex items-center justify-between gap-4 px-8 py-5 border-t border-black/[0.06] dark:border-white/[0.05] bg-slate-50 dark:bg-[#151d2e]">

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-1.5 text-[0.8rem] font-semibold text-slate-500 dark:text-slate-400 border border-black/[0.08] dark:border-white/[0.07] rounded-lg px-4 py-2.5 transition-all hover:border-slate-400 dark:hover:border-slate-500 hover:text-slate-700 dark:hover:text-slate-200">
                    <svg class="w-[13px] h-[13px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    Cancel
                </a>

                <button wire:click="save"
                    class="inline-flex items-center gap-1.5 text-[0.8rem] font-bold tracking-wide text-white dark:text-[#0b0f19] bg-slate-900 dark:bg-sky-400 border-none rounded-lg px-5 py-2.5 cursor-pointer transition-all hover:bg-slate-700 dark:hover:bg-sky-300 hover:-translate-y-px active:translate-y-0 active:scale-[0.98]">
                    <svg class="w-[13px] h-[13px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Create Project
                </button>

            </div>

        </div>

    </div>
</div>

<script>
    const statusMeta = {
        wip: {
            dot: 'bg-amber-400',
            badge: 'text-amber-600 dark:text-amber-400',
            label: 'Work in progress'
        },
        live: {
            dot: 'bg-green-400',
            badge: 'text-green-600 dark:text-green-400',
            label: 'Live – Deployed'
        },
        hidden: {
            dot: 'bg-slate-400',
            badge: 'text-slate-500 dark:text-slate-500',
            label: 'Hidden draft'
        },
    };

    function updateStatusBadge(sel) {
        const meta = statusMeta[sel.value] || statusMeta.wip;
        const badge = document.getElementById('status-badge');
        const dot = document.getElementById('status-dot');
        const label = document.getElementById('status-label');
        dot.className = `w-[7px] h-[7px] rounded-full shrink-0 ${meta.dot}`;
        badge.className = `inline-flex items-center gap-1.5 text-[0.7rem] font-semibold mt-0.5 ${meta.badge}`;
        label.textContent = meta.label;
    }

    function renderTags(val) {
        const preview = document.getElementById('tags-preview');
        const tags = val.split(',').map(t => t.trim()).filter(Boolean);
        preview.innerHTML = tags.map(t =>
            `<span class="text-[0.65rem] font-semibold px-2 py-0.5 rounded-full bg-sky-500/[0.07] text-sky-600 dark:text-sky-400 border border-sky-500/[0.18] dark:border-sky-400/[0.15] tracking-wide">${t}</span>`
        ).join('');
    }

    function thumbPreview(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('thumb-img').src = e.target.result;
            document.getElementById('thumb-fname').textContent = file.name;
            document.getElementById('thumb-empty').classList.add('hidden');
            document.getElementById('thumb-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function thumbClear(e) {
        e.stopPropagation();
        e.preventDefault();
        document.getElementById('thumb-input').value = '';
        document.getElementById('thumb-img').src = '';
        document.getElementById('thumb-preview').classList.add('hidden');
        document.getElementById('thumb-empty').classList.remove('hidden');
    }

    function thumbDragOver(e) {
        e.preventDefault();
        document.getElementById('thumb-zone').classList.add('drag-over');
    }

    function thumbDragLeave() {
        document.getElementById('thumb-zone').classList.remove('drag-over');
    }

    function thumbDrop(e) {
        e.preventDefault();
        document.getElementById('thumb-zone').classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (!file || !file.type.startsWith('image/')) return;
        const input = document.getElementById('thumb-input');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        thumbPreview(input);
    }
</script>

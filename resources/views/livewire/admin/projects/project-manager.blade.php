<div class="space-y-7">
    <style>
        /* ─── Trix dark theme ─────────────────────────────────── */
        trix-toolbar {
            background: #0c1829 !important;
            border: 1px solid #1e3a5a !important;
            border-bottom: none !important;
            border-radius: 10px 10px 0 0 !important;
            padding: 8px 10px !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }

        trix-toolbar .trix-button-group {
            border: 1px solid #1e3a5a !important;
            border-radius: 6px !important;
            margin: 0 2px !important;
            overflow: hidden;
            background: #080f1e !important;
        }

        trix-toolbar .trix-button {
            background: transparent !important;
            border: none !important;
            border-bottom: none !important;
            color: #64748b !important;
            padding: 5px 9px !important;
            min-width: 30px;
            height: 32px;
            font-size: 0.8rem !important;
            transition: background 0.12s, color 0.12s;
        }

        trix-toolbar .trix-button:hover {
            background: rgba(34, 211, 238, 0.08) !important;
            color: #22d3ee !important;
        }

        trix-toolbar .trix-button.trix-active {
            background: rgba(34, 211, 238, 0.12) !important;
            color: #22d3ee !important;
        }

        trix-toolbar .trix-button--icon::before {
            opacity: 0.7;
            filter: invert(1) brightness(0.7);
        }

        trix-toolbar .trix-button.trix-active::before,
        trix-toolbar .trix-button:hover::before {
            opacity: 1;
            filter: invert(0.7) sepia(1) saturate(5) hue-rotate(155deg);
        }

        trix-toolbar .trix-button-group--file-tools {
            display: none !important;
        }

        trix-toolbar .trix-dialog {
            background: #0c1829 !important;
            border: 1px solid #1e3a5a !important;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        }

        trix-toolbar .trix-input--dialog {
            background: #080f1e !important;
            border: 1px solid #1e3a5a !important;
            color: #e2e8f0 !important;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 0.82rem;
        }

        trix-toolbar .trix-input--dialog:focus {
            border-color: #22d3ee !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.1);
        }

        trix-toolbar .trix-button--dialog {
            background: #0e1f38 !important;
            color: #22d3ee !important;
            border: 1px solid rgba(34, 211, 238, 0.3) !important;
            border-radius: 6px !important;
            padding: 5px 12px !important;
            font-size: 0.8rem !important;
            transition: background 0.15s;
        }

        trix-toolbar .trix-button--dialog:hover {
            background: rgba(34, 211, 238, 0.12) !important;
        }

        trix-editor {
            background: #080f1e !important;
            border: 1px solid #1e3a5a !important;
            border-top: none !important;
            border-radius: 0 0 10px 10px !important;
            color: #cbd5e1 !important;
            min-height: 180px !important;
            /* taller editor */
            max-height: 280px !important;
            overflow-y: auto !important;
            padding: 14px 16px !important;
            font-size: 0.9rem !important;
            line-height: 1.8 !important;
            caret-color: #22d3ee;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        trix-editor:focus {
            border-color: #22d3ee !important;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.08) !important;
            outline: none !important;
        }

        trix-editor a {
            color: #22d3ee;
            text-decoration: underline;
        }

        trix-editor strong {
            color: #e2e8f0;
            font-weight: 600;
        }

        trix-editor em {
            color: #94a3b8;
        }

        trix-editor h1 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #f1f5f9;
            margin: 8px 0 4px;
        }

        trix-editor h2 {
            font-size: 1rem;
            font-weight: 600;
            color: #e2e8f0;
            margin: 6px 0 3px;
        }

        trix-editor blockquote {
            border-left: 3px solid #22d3ee;
            padding-left: 12px;
            color: #94a3b8;
            font-style: italic;
            margin: 8px 0;
        }

        trix-editor pre {
            background: #0c1829;
            border: 1px solid #1e3a5a;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.8rem;
            color: #94a3b8;
            font-family: monospace;
            overflow-x: auto;
        }

        trix-editor ul,
        trix-editor ol {
            padding-left: 1.4rem;
            color: #cbd5e1;
            line-height: 2;
        }

        trix-editor::-webkit-scrollbar {
            width: 4px;
        }

        trix-editor::-webkit-scrollbar-thumb {
            background: #1e3a5a;
            border-radius: 4px;
        }

        trix-editor:empty:not(:focus)::before {
            color: #2d3f56 !important;
        }

        /* ─── Card animations ─────────────────────────────────── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pm-card-enter {
            animation: fadeUp 0.28s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .pm-modal-in {
            animation: modalIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* ─── Scrollbar inside modal ──────────────────────────── */
        .pm-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .pm-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .pm-scroll::-webkit-scrollbar-thumb {
            background: #1a2d4a;
            border-radius: 4px;
        }

        /* ─── Thumbnail drop zone ─────────────────────────────── */
        .pm-dropzone {
            border: 2px dashed #1a2d4a;
            border-radius: 10px;
            background: #080f1e;
            transition: border-color 0.18s, background 0.18s;
            cursor: pointer;
        }

        .pm-dropzone:hover {
            border-color: #22d3ee;
            background: rgba(34, 211, 238, 0.03);
        }

        /* ─── AI buttons ──────────────────────────────────────── */
        .pm-ai-btn {
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            color: #64748b;
            border: 1px solid #1a2d4a;
            background: #080f1e;
            transition: color 0.15s, border-color 0.15s, background 0.15s;
            white-space: nowrap;
        }

        .pm-ai-btn:hover {
            color: #22d3ee;
            border-color: rgba(34, 211, 238, 0.35);
            background: rgba(34, 211, 238, 0.05);
        }

        /* ─── Input base (component-scoped) ──────────────────── */
        .pm-input {
            width: 100%;
            background: #080f1e;
            border: 1px solid #1a2d4a;
            border-radius: 8px;
            color: #cbd5e1;
            padding: 8px 12px;
            font-size: 0.875rem;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .pm-input:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.07);
            outline: none;
        }

        .pm-input::placeholder {
            color: #2d3f56;
        }

        .pm-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #475569;
            margin-bottom: 5px;
        }

        .pm-error {
            font-size: 0.7rem;
            color: #f87171;
            margin-top: 4px;
        }

        /* ─── Status pills ────────────────────────────────────── */
        .pill-live {
            background: rgba(74, 222, 128, 0.1);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.25);
        }

        .pill-wip {
            background: rgba(251, 146, 60, 0.1);
            color: #fb923c;
            border: 1px solid rgba(251, 146, 60, 0.25);
        }

        .pill-hidden {
            background: rgba(248, 113, 113, 0.1);
            color: #f87171;
            border: 1px solid rgba(248, 113, 113, 0.25);
        }
    </style>


    <div class="space-y-7">

        {{-- ══ HEADER ═══════════════════════════════════════════════ --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Project Manager</h2>
                <p class="text-xs text-slate-500 mt-1 tracking-wide">Create, edit and manage portfolio projects</p>
            </div>
            <button wire:click="create"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                       bg-cyan-400 hover:bg-cyan-300 text-[#080f1e]
                       shadow-lg shadow-cyan-500/20 hover:shadow-cyan-400/30 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Project
            </button>
        </div>


        {{-- ══ FLASH ══════════════════════════════════════════════════ --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-center gap-2.5 px-4 py-3 rounded-xl text-xs font-mono
                        border border-cyan-400/20 bg-cyan-400/8 text-cyan-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif


        {{-- ══ EMPTY STATE ════════════════════════════════════════════ --}}
        @if ($projects->isEmpty())
            <div class="rounded-2xl border border-dashed border-[#1a2d4a] bg-[#080f1e] py-24 text-center">
                <div class="flex flex-col items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-2xl bg-cyan-400/8 border border-cyan-400/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-cyan-400/60" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.4" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l9 4 9-4M3 12l9 4 9-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-300">No projects yet</p>
                        <p class="text-xs text-slate-600 mt-1">
                            Click <span class="text-cyan-400 font-medium">New Project</span> to get started.
                        </p>
                    </div>
                </div>
            </div>
        @else
            {{-- ══ PROJECT GRID ════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach ($projects as $project)
                    <div class="pm-card-enter rounded-2xl border border-[#1a2d4a] bg-[#0c1829] overflow-hidden
                                flex flex-col group hover:border-[#264166]
                                hover:shadow-xl hover:shadow-black/40 transition-all duration-300"
                        style="animation-delay: {{ $loop->index * 40 }}ms">

                        {{-- THUMBNAIL --}}
                        <div class="relative overflow-hidden">
                            @if ($project->thumbnail)
                                <img src="/storage/{{ $project->thumbnail }}"
                                    class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-44 flex flex-col items-center justify-center
                                            bg-gradient-to-br from-[#080f1e] to-[#0c1829] gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-700"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <span class="text-[10px] text-slate-700">No thumbnail</span>
                                </div>
                            @endif

                            {{-- Top accent bar --}}
                            <div
                                class="absolute inset-x-0 top-0 h-[3px]
                                @if ($project->status === 'live') bg-gradient-to-r from-green-400 to-emerald-300
                                @elseif ($project->status === 'wip') bg-gradient-to-r from-orange-400 to-amber-300
                                @else                                bg-gradient-to-r from-red-400 to-rose-300 @endif">
                            </div>

                            {{-- Status badge --}}
                            <div class="absolute top-3 left-3">
                                @if ($project->status === 'live')
                                    <span
                                        class="pill-live inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-widest backdrop-blur-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> LIVE
                                    </span>
                                @elseif ($project->status === 'wip')
                                    <span
                                        class="pill-wip inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-widest backdrop-blur-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> WIP
                                    </span>
                                @else
                                    <span
                                        class="pill-hidden inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-widest backdrop-blur-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> HIDDEN
                                    </span>
                                @endif
                            </div>

                            {{-- Link icons (top right) --}}
                            @if ($project->live_url || $project->repo_url)
                                <div
                                    class="absolute top-3 right-3 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    @if ($project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank"
                                            class="p-1.5 rounded-lg bg-black/50 backdrop-blur-sm text-slate-300 hover:text-cyan-400 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($project->repo_url)
                                        <a href="{{ $project->repo_url }}" target="_blank"
                                            class="p-1.5 rounded-lg bg-black/50 backdrop-blur-sm text-slate-300 hover:text-cyan-400 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- CARD BODY --}}
                        <div class="p-5 flex flex-col gap-3 flex-1">

                            <h3 class="text-sm font-semibold text-white leading-snug line-clamp-1">
                                {{ $project->title }}
                            </h3>

                            @if ($project->description)
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {!! strip_tags($project->description) !!}
                                </p>
                            @endif

                            @if ($project->tags)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($project->tags as $tag)
                                        <span
                                            class="px-2 py-0.5 text-[10px] rounded-md
                                                     bg-[#080f1e] border border-[#1a2d4a] text-slate-500">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            @if ($project->start_date)
                                <p class="text-[10px] text-slate-600 flex items-center gap-1 mt-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }}
                                    →
                                    {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('M Y') : 'Present' }}
                                </p>
                            @endif

                            <div class="border-t border-[#1a2d4a] pt-3 flex items-center justify-between mt-auto">
                                <div class="flex gap-1.5">
                                    <button wire:click="edit({{ $project->id }})"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium
                                               bg-[#0e1f38] text-cyan-400 border border-cyan-400/20
                                               hover:bg-cyan-400/10 hover:border-cyan-400/40 transition">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $project->id }})"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium
                                               bg-[#1a0909] text-red-400 border border-red-400/20
                                               hover:bg-red-400/10 hover:border-red-400/40 transition">
                                        Delete
                                    </button>
                                </div>

                                <button wire:click="toggleVisibility({{ $project->id }})"
                                    title="{{ $project->is_visible ? 'Hide project' : 'Show project' }}"
                                    class="p-1.5 rounded-lg border border-[#1a2d4a]
                                           hover:border-cyan-400/40 hover:bg-cyan-400/5 transition">
                                    @if ($project->is_visible)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-600"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    @endif
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

        @endif


        {{-- ══ CREATE / EDIT MODAL ════════════════════════════════════ --}}
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(2,6,18,0.88); backdrop-filter: blur(10px);" x-data
                x-on:keydown.escape.window="$wire.closeModal()">

                <div class="pm-modal-in w-full max-w-4xl flex flex-col rounded-2xl
                            border border-[#1a2d4a] shadow-2xl shadow-black/70"
                    style="background: linear-gradient(160deg,#0c1829 0%,#080f1e 100%); max-height: 92vh;">

                    {{-- MODAL HEADER --}}
                    <div
                        class="relative flex items-center justify-between px-7 py-5 flex-shrink-0 border-b border-[#1a2d4a]">
                        {{-- Top glow line --}}
                        <div class="absolute inset-x-0 top-0 h-px rounded-t-2xl"
                            style="background: linear-gradient(90deg, transparent, rgba(34,211,238,0.4), transparent);">
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-white tracking-tight">
                                {{ $editingId ? 'Edit Project' : 'New Project' }}
                            </h3>
                            <p class="text-[10px] text-slate-600 mt-0.5 uppercase tracking-wider">
                                {{ $editingId ? 'Update project details' : 'Fill in the project details below' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-1.5">
                            {{-- Status pills --}}
                            <div
                                class="flex items-center gap-1 p-1 rounded-lg border border-[#1a2d4a] bg-[#080f1e] mr-1">
                                <button wire:click="$set('status','live')"
                                    class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest transition
                                        {{ $status === 'live' ? 'bg-green-400/15 text-green-400 border border-green-400/30' : 'text-slate-600 hover:text-green-400' }}">
                                    LIVE
                                </button>
                                <button wire:click="$set('status','wip')"
                                    class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest transition
                                        {{ $status === 'wip' ? 'bg-orange-400/15 text-orange-400 border border-orange-400/30' : 'text-slate-600 hover:text-orange-400' }}">
                                    WIP
                                </button>
                                <button wire:click="$set('status','hidden')"
                                    class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest transition
                                        {{ $status === 'hidden' ? 'bg-red-400/15 text-red-400 border border-red-400/30' : 'text-slate-600 hover:text-red-400' }}">
                                    HIDDEN
                                </button>
                            </div>

                            @if ($editingId)
                                @php $proj = \App\Models\Project::find($editingId); @endphp
                                <button wire:click="toggleVisibility({{ $editingId }})"
                                    title="{{ $proj?->is_visible ? 'Hide' : 'Show' }}"
                                    class="p-2 rounded-lg border border-[#1a2d4a] text-slate-500
                                           hover:text-cyan-400 hover:border-cyan-400/30 hover:bg-cyan-400/5 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $editingId }})" title="Delete"
                                    class="p-2 rounded-lg border border-[#1a2d4a] text-slate-500
                                           hover:text-red-400 hover:border-red-400/30 hover:bg-red-400/5 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif

                            <button wire:click="closeModal"
                                class="p-2 rounded-lg border border-[#1a2d4a] text-slate-500
                                       hover:text-white hover:border-slate-500 hover:bg-white/5 transition ml-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- SCROLLABLE BODY --}}
                    <div class="pm-scroll overflow-y-auto flex-1 px-7 py-6 space-y-5">

                        {{-- Title + Live URL --}}
                        <div class="grid grid-cols-5 gap-3">
                            <div class="col-span-3">
                                <label class="pm-label">Project Title <span class="text-red-400">*</span></label>
                                <input wire:model.defer="title" type="text" placeholder="E-Commerce Platform"
                                    class="pm-input">
                                @error('title')
                                    <p class="pm-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="pm-label">Live URL</label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5 text-slate-600 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                    </svg>
                                    <input wire:model.defer="live_url" type="text" placeholder="https://..."
                                        class="pm-input pl-9">
                                </div>
                                @error('live_url')
                                    <p class="pm-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tags + Repo URL --}}
                        <div class="grid grid-cols-5 gap-3">
                            <div class="col-span-3">
                                <label class="pm-label">Tags</label>
                                <input wire:model.defer="tags" type="text" placeholder="Laravel, MySQL, Alpine.js"
                                    class="pm-input">
                                <p class="text-[10px] text-slate-700 mt-1">Comma-separated</p>
                                @error('tags')
                                    <p class="pm-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="pm-label">Repo URL</label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-3.5 h-3.5 text-slate-600 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                    </svg>
                                    <input wire:model.defer="repo_url" type="text"
                                        placeholder="https://github.com/..." class="pm-input pl-9">
                                </div>
                                @error('repo_url')
                                    <p class="pm-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Dates --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="pm-label">Start Date</label>
                                <input wire:model.defer="start_date" type="month" class="pm-input">
                                @error('start_date')
                                    <p class="pm-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="pm-label">End Date</label>
                                <input wire:model.defer="end_date" type="month" class="pm-input">
                                @error('end_date')
                                    <p class="pm-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Description (Trix) --}}
                        <div x-data="{
                            init() {
                                this.$nextTick(() => {
                                    const editor = this.$refs.trix;
                                    if (editor && @js($description)) {
                                        editor.editor.loadHTML(@js($description));
                                    }
                                });
                            }
                        }">
                            <label class="pm-label">Description</label>
                            <input id="trix-description-input" type="hidden" value="{{ $description }}">
                            <div wire:ignore>
                                <trix-editor x-ref="trix" input="trix-description-input"
                                    x-on:trix-change="$wire.set('description', $event.target.value)"
                                    placeholder="What does this project do? Key features, tech choices, impact...">
                                </trix-editor>
                            </div>
                            @error('description')
                                <p class="pm-error">{{ $message }}</p>
                            @enderror

                            {{-- AI quick actions --}}
                            <div class="flex items-center gap-2 flex-wrap mt-2.5">
                                <span class="text-slate-700 text-xs select-none">✦</span>
                                <button type="button" wire:click="improveWriting" class="pm-ai-btn">✏ Improve
                                    Writing</button>
                                <button type="button" wire:click="suggestContent" class="pm-ai-btn">💡 Suggest
                                    Content</button>
                                <button type="button" wire:click="grammarCheck" class="pm-ai-btn">✔ Grammar
                                    Check</button>
                                <button type="button" wire:click="makeShorter" class="pm-ai-btn">↓ Shorter</button>
                            </div>
                        </div>

                        {{-- Thumbnail --}}
                        <div>
                            <label class="pm-label">Thumbnail</label>

                            <label
                                class="pm-dropzone flex flex-col items-center justify-center gap-2.5 py-8 px-4 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-700" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.4" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <div>
                                    <p class="text-sm text-slate-400 font-medium">Click to upload thumbnail</p>
                                    <p class="text-[10px] text-slate-600 mt-0.5">PNG · JPG · WEBP — max 2 MB</p>
                                </div>
                                <input wire:model="thumbnail" type="file" accept="image/*" class="sr-only">
                            </label>

                            @error('thumbnail')
                                <p class="pm-error mt-1">{{ $message }}</p>
                            @enderror

                            <div wire:loading wire:target="thumbnail"
                                class="flex items-center gap-2 mt-2 text-xs text-cyan-400">
                                <svg class="w-3.5 h-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                                Uploading...
                            </div>

                            {{-- Preview area: new upload takes priority over existing --}}
                            @if ($thumbnail)
                                <div wire:loading.remove wire:target="thumbnail"
                                    class="mt-3 rounded-xl overflow-hidden border border-cyan-400/30 relative group">
                                    <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full max-h-56 object-cover">
                                    <div
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span
                                            class="text-xs text-white font-medium px-3 py-1.5 rounded-lg bg-black/60 border border-white/10">
                                            New thumbnail — will be saved on submit
                                        </span>
                                    </div>
                                </div>
                            @elseif ($editingId)
                                @php $existingThumb = \App\Models\Project::find($editingId)?->thumbnail; @endphp
                                @if ($existingThumb)
                                    <div
                                        class="mt-3 rounded-xl overflow-hidden border border-[#1a2d4a] relative group">
                                        <img src="/storage/{{ $existingThumb }}"
                                            class="w-full max-h-56 object-cover opacity-70">
                                        <div class="absolute inset-0 bg-black/30 flex items-end">
                                            <span class="text-[10px] text-slate-400 px-3 py-2">
                                                Current thumbnail — upload a new file to replace
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>

                    </div>

                    {{-- MODAL FOOTER --}}
                    <div class="flex items-center justify-between px-7 py-4 flex-shrink-0
                                border-t border-[#1a2d4a]"
                        style="background: rgba(8,15,30,0.6);">
                        <p class="text-[10px] text-slate-700">
                            <span class="text-red-400">*</span> Required
                        </p>
                        <div class="flex items-center gap-2.5">
                            <button wire:click="closeModal"
                                class="px-5 py-2 rounded-xl text-sm font-medium text-slate-500
                                       border border-[#1a2d4a] hover:border-slate-500 hover:text-slate-300 transition">
                                Cancel
                            </button>
                            <button wire:click="save"
                                class="flex items-center gap-2 px-6 py-2 rounded-xl text-sm font-semibold
                                       text-[#080f1e] bg-cyan-400 hover:bg-cyan-300 transition
                                       shadow-lg shadow-cyan-500/20 hover:shadow-cyan-400/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    @if ($editingId)
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    @endif
                                </svg>
                                {{ $editingId ? 'Update Project' : 'Create Project' }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        @endif


        {{-- ══ DELETE CONFIRM ═════════════════════════════════════════ --}}
        @if ($showDelete)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(2,6,18,0.88); backdrop-filter: blur(10px);">
                <div class="pm-modal-in w-full max-w-sm rounded-2xl border border-[#1a2d4a] p-8
                            space-y-5 text-center shadow-2xl shadow-black/70"
                    style="background: linear-gradient(160deg,#0c1829 0%,#080f1e 100%);">

                    <div
                        class="w-14 h-14 rounded-2xl bg-red-400/10 border border-red-400/20
                                flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-white">Delete Project?</h3>
                        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
                            This action cannot be undone.<br>The thumbnail will also be permanently deleted.
                        </p>
                    </div>

                    <div class="flex justify-center gap-3 pt-1">
                        <button wire:click="closeModal"
                            class="px-5 py-2 rounded-xl text-sm font-medium text-slate-500
                                   border border-[#1a2d4a] hover:border-slate-500 hover:text-slate-300 transition">
                            Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-5 py-2 rounded-xl text-sm font-semibold text-white
                                   bg-red-500/80 hover:bg-red-500 border border-red-400/30
                                   transition shadow-lg shadow-red-500/20">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>

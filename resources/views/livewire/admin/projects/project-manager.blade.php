<div class="space-y-8">
    <style>
        /* ── Fonts ─────────────────────────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,400&family=Sora:wght@300;400;500;600;700;800&display=swap');

        .pm-root { font-family: 'Sora', sans-serif; }
        .pm-mono { font-family: 'DM Mono', monospace; }

        /* ── Tokens ─────────────────────────────────────────────── */
        :root {
            --bg0:    #05080f;
            --bg1:    #090e1a;
            --bg2:    #0d1423;
            --bg3:    #111c2e;
            --line:   #172035;
            --line2:  #1e2f48;
            --cyan:   #22d3ee;
            --cyan2:  #67e8f9;
            --purple: #a78bfa;
            --green:  #4ade80;
            --orange: #fb923c;
            --red:    #f87171;
            --t1:     #f1f5f9;
            --t2:     #94a3b8;
            --t3:     #475569;
            --t4:     #1e2f48;
        }

        /* ── Trix dark theme ─────────────────────────────────── */
        trix-toolbar {
            background: var(--bg2) !important;
            border: 1px solid var(--line2) !important;
            border-bottom: none !important;
            border-radius: 10px 10px 0 0 !important;
            padding: 8px 10px !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }
        trix-toolbar .trix-button-group {
            border: 1px solid var(--line2) !important;
            border-radius: 6px !important;
            margin: 0 2px !important;
            overflow: hidden;
            background: var(--bg1) !important;
        }
        trix-toolbar .trix-button {
            background: transparent !important;
            border: none !important;
            border-bottom: none !important;
            color: var(--t3) !important;
            padding: 5px 9px !important;
            min-width: 30px;
            height: 32px;
            font-size: 0.8rem !important;
            transition: background 0.12s, color 0.12s;
        }
        trix-toolbar .trix-button:hover {
            background: rgba(34,211,238,0.08) !important;
            color: var(--cyan) !important;
        }
        trix-toolbar .trix-button.trix-active {
            background: rgba(34,211,238,0.12) !important;
            color: var(--cyan) !important;
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
        trix-toolbar .trix-button-group--file-tools { display: none !important; }
        trix-toolbar .trix-dialog {
            background: var(--bg2) !important;
            border: 1px solid var(--line2) !important;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0,0,0,.6);
        }
        trix-toolbar .trix-input--dialog {
            background: var(--bg1) !important;
            border: 1px solid var(--line2) !important;
            color: var(--t1) !important;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: .82rem;
        }
        trix-toolbar .trix-input--dialog:focus {
            border-color: var(--cyan) !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(34,211,238,.1);
        }
        trix-toolbar .trix-button--dialog {
            background: var(--bg3) !important;
            color: var(--cyan) !important;
            border: 1px solid rgba(34,211,238,.3) !important;
            border-radius: 6px !important;
            padding: 5px 12px !important;
            font-size: .8rem !important;
            transition: background .15s;
        }
        trix-toolbar .trix-button--dialog:hover { background: rgba(34,211,238,.12) !important; }

        trix-editor {
            background: var(--bg1) !important;
            border: 1px solid var(--line2) !important;
            border-top: none !important;
            border-radius: 0 0 10px 10px !important;
            color: #cbd5e1 !important;
            min-height: 160px !important;
            max-height: 260px !important;
            overflow-y: auto !important;
            padding: 14px 16px !important;
            font-size: .9rem !important;
            line-height: 1.8 !important;
            caret-color: var(--cyan);
            transition: border-color .2s, box-shadow .2s;
        }
        trix-editor:focus {
            border-color: var(--cyan) !important;
            box-shadow: 0 0 0 3px rgba(34,211,238,.08) !important;
            outline: none !important;
        }
        trix-editor a { color: var(--cyan); text-decoration: underline; }
        trix-editor strong { color: var(--t1); font-weight: 600; }
        trix-editor blockquote { border-left: 3px solid var(--cyan); padding-left: 12px; color: var(--t2); font-style: italic; margin: 8px 0; }
        trix-editor pre { background: var(--bg2); border: 1px solid var(--line2); border-radius: 6px; padding: 10px 14px; font-size: .8rem; color: var(--t2); font-family: monospace; overflow-x: auto; }
        trix-editor ul, trix-editor ol { padding-left: 1.4rem; color: #cbd5e1; line-height: 2; }
        trix-editor::-webkit-scrollbar { width: 4px; }
        trix-editor::-webkit-scrollbar-thumb { background: var(--line2); border-radius: 4px; }
        trix-editor:empty:not(:focus)::before { color: var(--t4) !important; }

        /* ── Card grid ───────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .pm-card-enter { animation: fadeUp .32s cubic-bezier(.16,1,.3,1) both; }

        /* ── Modal ───────────────────────────────────────────── */
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(24px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .pm-modal-in { animation: modalIn .24s cubic-bezier(.16,1,.3,1) forwards; }

        /* ── Scrollbar ───────────────────────────────────────── */
        .pm-scroll::-webkit-scrollbar { width: 4px; }
        .pm-scroll::-webkit-scrollbar-track { background: transparent; }
        .pm-scroll::-webkit-scrollbar-thumb { background: var(--line2); border-radius: 4px; }

        /* ── Drop zone ───────────────────────────────────────── */
        .pm-dropzone {
            border: 2px dashed var(--line2);
            border-radius: 12px;
            background: var(--bg1);
            transition: border-color .18s, background .18s;
            cursor: pointer;
        }
        .pm-dropzone:hover {
            border-color: var(--cyan);
            background: rgba(34,211,238,.03);
        }

        /* ── Input ───────────────────────────────────────────── */
        .pm-input {
            width: 100%;
            background: var(--bg1);
            border: 1px solid var(--line2);
            border-radius: 10px;
            color: var(--t1);
            padding: 9px 13px;
            font-size: .875rem;
            font-family: 'Sora', sans-serif;
            transition: border-color .18s, box-shadow .18s;
        }
        .pm-input:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px rgba(34,211,238,.07);
            outline: none;
        }
        .pm-input::placeholder { color: var(--t4); }

        .pm-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--t3);
            margin-bottom: 6px;
            font-family: 'DM Mono', monospace;
        }
        .pm-label .req { color: var(--red); }
        .pm-error { font-size: .7rem; color: var(--red); margin-top: 4px; font-family: 'DM Mono', monospace; }

        /* ── Status pills ─────────────────────────────────────── */
        .pill-live   { background: rgba(74,222,128,.1);  color: #4ade80; border: 1px solid rgba(74,222,128,.25); }
        .pill-wip    { background: rgba(251,146,60,.1);  color: #fb923c; border: 1px solid rgba(251,146,60,.25); }
        .pill-hidden { background: rgba(248,113,113,.1); color: #f87171; border: 1px solid rgba(248,113,113,.25); }

        /* ── Status toggle (card inline) ──────────────────────── */
        .status-toggle {
            display: flex;
            border: 1px solid var(--line2);
            border-radius: 8px;
            overflow: hidden;
            background: var(--bg1);
        }
        .status-toggle button {
            flex: 1;
            padding: 4px 0;
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .1em;
            font-family: 'DM Mono', monospace;
            transition: background .15s, color .15s;
            color: var(--t3);
        }
        .status-toggle button.active-live   { background: rgba(74,222,128,.15);  color: #4ade80; }
        .status-toggle button.active-wip    { background: rgba(251,146,60,.15);  color: #fb923c; }
        .status-toggle button.active-hidden { background: rgba(248,113,113,.15); color: #f87171; }
        .status-toggle button:hover:not(.active-live):not(.active-wip):not(.active-hidden) {
            color: var(--t2);
            background: rgba(255,255,255,.03);
        }

        /* ── AI buttons ───────────────────────────────────────── */
        .pm-ai-btn {
            padding: 4px 11px;
            border-radius: 6px;
            font-size: .68rem;
            color: var(--t3);
            border: 1px solid var(--line2);
            background: var(--bg1);
            transition: color .15s, border-color .15s, background .15s;
            white-space: nowrap;
            font-family: 'DM Mono', monospace;
        }
        .pm-ai-btn:hover {
            color: var(--cyan);
            border-color: rgba(34,211,238,.35);
            background: rgba(34,211,238,.05);
        }

        /* ── Section divider ─────────────────────────────────── */
        .pm-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 2px 0;
        }
        .pm-divider span { font-size: .62rem; color: var(--t4); text-transform: uppercase; letter-spacing: .12em; font-family: 'DM Mono', monospace; white-space: nowrap; }
        .pm-divider::before, .pm-divider::after { content: ''; flex: 1; height: 1px; background: var(--line); }

        /* ── Glow card hover ─────────────────────────────────── */
        .pm-proj-card {
            position: relative;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: var(--bg1);
            overflow: hidden;
            transition: border-color .3s, box-shadow .3s, transform .3s;
        }
        .pm-proj-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at top, rgba(34,211,238,.04) 0%, transparent 70%);
            opacity: 0;
            transition: opacity .4s;
            pointer-events: none;
        }
        .pm-proj-card:hover {
            border-color: var(--line2);
            box-shadow: 0 0 0 1px rgba(34,211,238,.08), 0 20px 60px rgba(0,0,0,.5);
            transform: translateY(-2px);
        }
        .pm-proj-card:hover::before { opacity: 1; }

        /* ── Modal field section header ──────────────────────── */
        .modal-section-label {
            font-size: .6rem;
            font-weight: 600;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--t4);
            font-family: 'DM Mono', monospace;
            padding: 0 0 10px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 14px;
        }

        /* ── Number badge ────────────────────────────────────── */
        .field-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 5px;
            background: var(--bg3);
            border: 1px solid var(--line2);
            font-size: .6rem;
            color: var(--t3);
            font-family: 'DM Mono', monospace;
            flex-shrink: 0;
        }
    </style>


    <div class="pm-root space-y-8">

        {{-- ══ HEADER ════════════════════════════════════════════════ --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="pm-mono text-[10px] tracking-[.18em] text-cyan-400/70 uppercase">Admin / Projects</span>
                </div>
                <h2 class="text-2xl font-bold tracking-tight" style="color:var(--t1);">Project Manager</h2>
                <p class="text-xs mt-1" style="color:var(--t3);">Create, edit and manage your portfolio projects</p>
            </div>
            <button wire:click="create"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex-shrink-0"
                style="background:var(--cyan);color:var(--bg0);box-shadow:0 0 20px rgba(34,211,238,.25);"
                onmouseover="this.style.boxShadow='0 0 30px rgba(34,211,238,.4)'"
                onmouseout="this.style.boxShadow='0 0 20px rgba(34,211,238,.25)'">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                New Project
            </button>
        </div>


        {{-- ══ FLASH ══════════════════════════════════════════════════ --}}
        @if(session('success'))
            <div x-data="{show:true}" x-init="setTimeout(()=>show=false,3500)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs pm-mono"
                style="border:1px solid rgba(34,211,238,.2);background:rgba(34,211,238,.06);color:var(--cyan2);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif


        {{-- ══ EMPTY STATE ════════════════════════════════════════════ --}}
        @if($projects->isEmpty())
            <div class="rounded-2xl py-28 text-center" style="border:1px dashed var(--line2);background:var(--bg1);">
                <div class="flex flex-col items-center gap-5">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:rgba(34,211,238,.06);border:1px solid rgba(34,211,238,.15);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" style="color:rgba(34,211,238,.5);" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l9 4 9-4M3 12l9 4 9-4"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold" style="color:var(--t2);">No projects yet</p>
                        <p class="text-xs mt-1.5" style="color:var(--t3);">Click <span style="color:var(--cyan);" class="font-medium">New Project</span> to get started.</p>
                    </div>
                </div>
            </div>

        @else
            {{-- ══ PROJECT GRID ════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($projects as $project)
                    <div class="pm-card-enter pm-proj-card flex flex-col"
                        style="animation-delay:{{ $loop->index * 45 }}ms">

                        {{-- THUMBNAIL --}}
                        <div class="relative overflow-hidden" style="height:180px;">
                            @if(!empty($project->thumbnail))
                                <img src="{{ Storage::disk('r2')->url($project->thumbnail) }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center gap-2"
                                    style="background:linear-gradient(135deg,var(--bg2),var(--bg0));">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" style="color:var(--line2);" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                    <span class="text-[10px] pm-mono" style="color:var(--t4);">No thumbnail</span>
                                </div>
                            @endif

                            {{-- gradient overlay bottom --}}
                            <div class="absolute inset-x-0 bottom-0 h-16"
                                style="background:linear-gradient(to top, var(--bg1), transparent);pointer-events:none;"></div>

                            {{-- Top accent bar --}}
                            <div class="absolute inset-x-0 top-0 h-[3px]
                                @if(($project->status ?? '') === 'live') bg-gradient-to-r from-green-400 to-emerald-300
                                @elseif(($project->status ?? '') === 'wip') bg-gradient-to-r from-orange-400 to-amber-300
                                @else bg-gradient-to-r from-red-400 to-rose-300 @endif"></div>

                            {{-- External link icons --}}
                            @if(!empty($project->live_url) || !empty($project->repo_url))
                                <div class="absolute top-3 right-3 flex gap-1.5">
                                    @if(!empty($project->live_url))
                                        <a href="{{ $project->live_url }}" target="_blank"
                                            class="p-1.5 rounded-lg transition"
                                            style="background:rgba(0,0,0,.55);backdrop-filter:blur(6px);color:var(--t2);"
                                            onmouseover="this.style.color='var(--cyan)'"
                                            onmouseout="this.style.color='var(--t2)'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if(!empty($project->repo_url))
                                        <a href="{{ $project->repo_url }}" target="_blank"
                                            class="p-1.5 rounded-lg transition"
                                            style="background:rgba(0,0,0,.55);backdrop-filter:blur(6px);color:var(--t2);"
                                            onmouseover="this.style.color='var(--cyan)'"
                                            onmouseout="this.style.color='var(--t2)'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- CARD BODY --}}
                        <div class="flex flex-col gap-3 p-5 flex-1">

                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-sm font-semibold leading-snug line-clamp-1" style="color:var(--t1);">
                                    {{ $project->title ?? 'Untitled' }}
                                </h3>
                                {{-- visibility eye --}}
                                @php $isVisible = $project->is_visible ?? true; @endphp
                                <button wire:click="toggleVisibility({{ $project->id }})"
                                    title="{{ $isVisible ? 'Hide' : 'Show' }}"
                                    class="flex-shrink-0 p-1 rounded-md transition"
                                    style="color:{{ $isVisible ? 'var(--cyan)' : 'var(--t1)' }};">
                                    @if($isVisible)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                        </svg>
                                    @endif
                                </button>
                            </div>

                            @if(!empty($project->description))
                                <p class="text-xs line-clamp-2 leading-relaxed" style="color:var(--t3);">
                                    {!! strip_tags($project->description) !!}
                                </p>
                            @endif

                            @if(!empty($project->tags) && is_array($project->tags))
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($project->tags as $tag)
                                        <span class="px-2 py-0.5 text-[10px] rounded-md pm-mono"
                                            style="background:var(--bg2);border:1px solid var(--line2);color:var(--t3);">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            @if(!empty($project->start_date))
                                <p class="text-[10px] pm-mono flex items-center gap-1.5 mt-auto" style="color:var(--t1);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }}
                                    →
                                    {{ !empty($project->end_date) ? \Carbon\Carbon::parse($project->end_date)->format('M Y') : 'Present' }}
                                </p>
                            @endif

                            {{-- STATUS TOGGLE ──────────── --}}
                            @php $projStatus = $project->status ?? 'wip'; @endphp
                            <div class="status-toggle mt-auto">
                                <button wire:click="updateStatus({{ $project->id }}, 'live')"
                                    class="{{ $projStatus === 'live' ? 'active-live' : '' }}">
                                    LIVE
                                </button>
                                <button wire:click="updateStatus({{ $project->id }}, 'wip')"
                                    class="{{ $projStatus === 'wip' ? 'active-wip' : '' }}"
                                    style="border-left:1px solid var(--line);border-right:1px solid var(--line);">
                                    WIP
                                </button>
                                <button wire:click="updateStatus({{ $project->id }}, 'hidden')"
                                    class="{{ $projStatus === 'hidden' ? 'active-hidden' : '' }}">
                                    HIDDEN
                                </button>
                            </div>

                            {{-- EDIT / DELETE ────────────── --}}
                            <div class="flex gap-2 pt-1" style="border-top:1px solid var(--line);">
                                <button wire:click="edit({{ $project->id }})"
                                    class="flex-1 py-2 rounded-lg text-xs font-medium transition"
                                    style="background:rgba(34,211,238,.06);color:var(--cyan);border:1px solid rgba(34,211,238,.18);"
                                    onmouseover="this.style.background='rgba(34,211,238,.12)'"
                                    onmouseout="this.style.background='rgba(34,211,238,.06)'">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete({{ $project->id }})"
                                    class="flex-1 py-2 rounded-lg text-xs font-medium transition"
                                    style="background:rgba(248,113,113,.06);color:var(--red);border:1px solid rgba(248,113,113,.18);"
                                    onmouseover="this.style.background='rgba(248,113,113,.12)'"
                                    onmouseout="this.style.background='rgba(248,113,113,.06)'">
                                    Delete
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif


        {{-- ══ CREATE / EDIT MODAL ════════════════════════════════════ --}}
        @if($showModal)
            <div class="fixed inset-0 z-50 flex"
                style="background:var(--bg0);"
                x-data x-on:keydown.escape.window="$wire.closeModal()">

                <div class="pm-modal-in w-full flex flex-col"
                    style="background:var(--bg1);border-left:1px solid var(--line2);border-right:1px solid var(--line2);">

                    {{-- MODAL HEADER ────────────────── --}}
                    <div class="relative flex-shrink-0 px-6 pt-6 pb-5"
                        style="border-bottom:1px solid var(--line);">
                        {{-- top glow line --}}
                        <div class="absolute inset-x-0 top-0 h-px rounded-t-2xl"
                            style="background:linear-gradient(90deg,transparent,rgba(34,211,238,.5),transparent);"></div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                {{-- icon --}}
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                    style="background:rgba(34,211,238,.08);border:1px solid rgba(34,211,238,.2);">
                                    @if($editingId)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color:var(--cyan);" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color:var(--cyan);" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold tracking-tight" style="color:var(--t1);font-size:1rem;">
                                        {{ $editingId ? 'Edit Project' : 'New Project' }}
                                    </h3>
                                    <p class="text-[10px] pm-mono mt-0.5" style="color:var(--t1);">
                                        {{ $editingId ? 'Update the details below' : 'Fill in the project details' }}
                                    </p>
                                </div>
                            </div>

                            {{-- header right: actions + close --}}
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if($editingId)
                                    <button wire:click="confirmDelete({{ $editingId }})" title="Delete"
                                        class="p-2 rounded-lg transition"
                                        style="border:1px solid var(--line2);color:var(--t3);"
                                        onmouseover="this.style.color='var(--red)';this.style.borderColor='rgba(248,113,113,.3)'"
                                        onmouseout="this.style.color='var(--t3)';this.style.borderColor='var(--line2)'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @endif
                                <button wire:click="closeModal"
                                    class="p-2 rounded-lg transition"
                                    style="border:1px solid var(--line2);color:var(--t3);"
                                    onmouseover="this.style.color='var(--t1)';this.style.borderColor='var(--t3)'"
                                    onmouseout="this.style.color='var(--t3)';this.style.borderColor='var(--line2)'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- SCROLLABLE BODY ──────────────── --}}
                    <div class="pm-scroll overflow-y-auto flex-1 py-6 space-y-6 px-6">

                        <div>
                            <p class="modal-section-label" style="color:var(--t1);">1. Basics</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="pm-label"><span class="field-num">1</span> Project Title <span class="req">*</span></label>
                                    <input wire:model="title" type="text" placeholder="E-Commerce Platform" class="pm-input">
                                    @error('title') <p class="pm-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="pm-label"><span class="field-num">2</span> Status</label>
                                    <div class="flex gap-2">
                                        <button type="button" wire:click="$set('status','live')"
                                            class="flex-1 py-2.5 rounded-lg text-xs font-bold pm-mono tracking-widest transition"
                                            style="{{ $status==='live' ? 'background:rgba(74,222,128,.15);color:#4ade80;border:1px solid rgba(74,222,128,.35);' : 'background:var(--bg2);color:var(--t3);border:1px solid var(--line2);' }}">
                                            LIVE
                                        </button>
                                        <button type="button" wire:click="$set('status','wip')"
                                            class="flex-1 py-2.5 rounded-lg text-xs font-bold pm-mono tracking-widest transition"
                                            style="{{ $status==='wip' ? 'background:rgba(251,146,60,.15);color:#fb923c;border:1px solid rgba(251,146,60,.35);' : 'background:var(--bg2);color:var(--t3);border:1px solid var(--line2);' }}">
                                            WIP
                                        </button>
                                        <button type="button" wire:click="$set('status','hidden')"
                                            class="flex-1 py-2.5 rounded-lg text-xs font-bold pm-mono tracking-widest transition"
                                            style="{{ $status==='hidden' ? 'background:rgba(248,113,113,.15);color:#f87171;border:1px solid rgba(248,113,113,.35);' : 'background:var(--bg2);color:var(--t3);border:1px solid var(--line2);' }}">
                                            HIDDEN
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="modal-section-label" style="color:var(--t1);">2. Links</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="pm-label"><span class="field-num">3</span> Live URL</label>
                                    <div class="relative">
                                        <input wire:model="live_url" type="text" placeholder="https://..." class="pm-input">
                                    </div>
                                    @error('live_url') <p class="pm-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="pm-label"><span class="field-num">4</span> Repo URL</label>
                                    <div class="relative">
                                        <input wire:model="repo_url" type="text" placeholder="https://github.com/..." class="pm-input">
                                    </div>
                                    @error('repo_url') <p class="pm-error">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="modal-section-label" style="color:var(--t1);">3. Meta</p>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-1">
                                    <label class="pm-label"><span class="field-num">5</span> Tags</label>
                                    <input wire:model="tags" type="text" placeholder="Laravel, Vue, MySQL" class="pm-input">
                                    <p class="text-[10px] pm-mono mt-1.5" style="color:var(--t1);">Comma-separated</p>
                                    @error('tags') <p class="pm-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="pm-label"><span class="field-num">6</span> Start Date</label>
                                    <input wire:model="start_date" type="month" class="pm-input">
                                    @error('start_date') <p class="pm-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="pm-label"><span class="field-num">7</span> End Date</label>
                                    <input wire:model="end_date" type="month" class="pm-input">
                                    @error('end_date') <p class="pm-error">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="modal-section-label" style="color:var(--t1);">4. Description</p>
                            <div>
                                <label class="pm-label"><span class="field-num">8</span> Description</label>
                                <textarea wire:model="description" rows="5" placeholder="What does this project do?..." class="pm-input resize-y"></textarea>
                                @error('description') <p class="pm-error mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <p class="modal-section-label" style="color:var(--t1);">5. Cover Thumbnail & Media Gallery</p>
                            
                            {{-- Primary Thumbnail --}}
                            <div class="mb-5">
                                <label class="pm-label"><span class="field-num">9</span> Cover Thumbnail (Main image)</label>
                                <label class="pm-dropzone flex flex-col items-center justify-center gap-3 py-6 px-4 text-center cursor-pointer">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                        style="background:rgba(34,211,238,.06);border:1px solid rgba(34,211,238,.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold" style="color:var(--t2);">Click to upload main cover</p>
                                        <p class="text-[10px] pm-mono mt-0.5" style="color:var(--t4);">PNG · JPG · WEBP</p>
                                    </div>
                                    <input wire:model="thumbnail" type="file" accept="image/*" class="sr-only">
                                </label>
                                @error('thumbnail') <p class="pm-error mt-1">{{ $message }}</p> @enderror

                                @if($thumbnail)
                                    <div class="mt-2.5 rounded-xl overflow-hidden relative border border-cyan-400/40">
                                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full max-h-40 object-cover">
                                        <div class="absolute bottom-0 inset-x-0 px-3 py-1.5 text-[10px] pm-mono bg-black/70 text-cyan-300">
                                            New Cover Thumbnail Preview
                                        </div>
                                    </div>
                                @elseif($existingThumbnail)
                                    <div class="mt-2.5 rounded-xl overflow-hidden relative border border-slate-700">
                                        <img src="{{ Storage::disk('r2')->url($existingThumbnail) }}" class="w-full max-h-40 object-cover opacity-75">
                                        <div class="absolute bottom-0 inset-x-0 px-3 py-1.5 text-[10px] pm-mono bg-black/70 text-slate-300">
                                            Current Cover Thumbnail
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Multiple Images & Videos Gallery --}}
                            <div class="mt-6 pt-5 border-t border-slate-800">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="pm-label mb-0"><span class="field-num">10</span> Slideshow Gallery (Images & Videos)</label>
                                    <span class="text-[10px] pm-mono text-cyan-400">Card Slideshow</span>
                                </div>
                                <p class="text-xs text-slate-400 mb-3">Add multiple images or short video clips (.mp4, .webm). When more than 1 media file is attached, an interactive slideshow will automatically play inside the project card!</p>

                                <label class="pm-dropzone flex flex-col items-center justify-center gap-2 py-6 px-4 text-center cursor-pointer border-dashed">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-purple-500/10 border border-purple-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-200">Click or Drag to add Photos & Videos</p>
                                        <p class="text-[10px] pm-mono text-slate-400 mt-0.5">MP4 · WEBM · JPG · PNG · WEBP (Max 25 MB)</p>
                                    </div>
                                    <input wire:model="newMedia" type="file" multiple accept="image/*,video/mp4,video/webm,video/ogg" class="sr-only">
                                </label>
                                @error('newMedia.*') <p class="pm-error mt-1">{{ $message }}</p> @enderror

                                <div wire:loading wire:target="newMedia" class="flex items-center gap-2 mt-2 text-xs pm-mono text-cyan-400">
                                    <svg class="w-3.5 h-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                    </svg>
                                    Uploading media files…
                                </div>

                                {{-- Media List Gallery Preview --}}
                                @if(!empty($existingMedia) || !empty($newMedia))
                                    <div class="mt-4 space-y-2">
                                        <p class="text-[11px] font-mono uppercase tracking-wider text-slate-400">Attached Media Items ({{ count($existingMedia) + count($newMedia) }})</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                            
                                            {{-- Existing Media --}}
                                            @foreach($existingMedia as $idx => $item)
                                                @php 
                                                    $itemType = is_array($item) ? ($item['type'] ?? '') : ($item->type ?? '');
                                                    $itemUrl = is_array($item) ? ($item['url'] ?? '') : ($item->url ?? '');
                                                    $isVid = $itemType === 'video' || str_ends_with(strtolower((string) $itemUrl), '.mp4') || str_ends_with(strtolower((string) $itemUrl), '.webm');
                                                    $mediaUrl = str_starts_with((string) $itemUrl, 'http') ? $itemUrl : Storage::disk('r2')->url($itemUrl);
                                                @endphp
                                                <div class="relative group rounded-lg overflow-hidden border border-slate-700 bg-slate-900 aspect-video flex items-center justify-center">
                                                    @if($isVid)
                                                        <video src="{{ $mediaUrl }}" class="w-full h-full object-cover" muted preload="metadata"></video>
                                                        <span class="absolute top-1 left-1 bg-purple-600/80 backdrop-blur-sm text-[9px] font-mono uppercase font-bold text-white px-1.5 py-0.5 rounded">
                                                            VIDEO
                                                        </span>
                                                    @else
                                                        <img src="{{ $mediaUrl }}" class="w-full h-full object-cover">
                                                        <span class="absolute top-1 left-1 bg-cyan-600/80 backdrop-blur-sm text-[9px] font-mono uppercase font-bold text-white px-1.5 py-0.5 rounded">
                                                            IMAGE
                                                        </span>
                                                    @endif

                                                    <button type="button" wire:click="removeExistingMedia({{ $idx }})"
                                                        class="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600/90 text-white flex items-center justify-center hover:bg-red-500 transition shadow-lg"
                                                        title="Delete media">
                                                        &times;
                                                    </button>
                                                </div>
                                            @endforeach

                                            {{-- New Uploads Preview --}}
                                            @foreach($newMedia as $idx => $item)
                                                @php
                                                    $ext = strtolower($item->getClientOriginalExtension());
                                                    $isVid = in_array($ext, ['mp4', 'webm', 'mov', 'ogg']);
                                                @endphp
                                                <div class="relative group rounded-lg overflow-hidden border border-cyan-400/50 bg-slate-900 aspect-video flex items-center justify-center">
                                                    @if($isVid)
                                                        <div class="flex flex-col items-center justify-center text-purple-400 p-2 text-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                            </svg>
                                                            <span class="text-[9px] font-mono truncate max-w-[90px]">{{ $item->getClientOriginalName() }}</span>
                                                        </div>
                                                        <span class="absolute top-1 left-1 bg-purple-600/90 text-[9px] font-mono font-bold text-white px-1.5 py-0.5 rounded">
                                                            NEW VIDEO
                                                        </span>
                                                    @else
                                                        <img src="{{ $item->temporaryUrl() }}" class="w-full h-full object-cover">
                                                        <span class="absolute top-1 left-1 bg-cyan-500/90 text-[9px] font-mono font-bold text-white px-1.5 py-0.5 rounded">
                                                            NEW IMAGE
                                                        </span>
                                                    @endif

                                                    <button type="button" wire:click="removeNewMedia({{ $idx }})"
                                                        class="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600/90 text-white flex items-center justify-center hover:bg-red-500 transition shadow-lg"
                                                        title="Remove upload">
                                                        &times;
                                                    </button>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- MODAL FOOTER ─────────────────── --}}
                    <div class="flex items-center justify-between px-6 sm:px-12 lg:px-24 xl:px-40 2xl:px-64 py-4 flex-shrink-0"
                        style="border-top:1px solid var(--line);background:rgba(5,8,15,.5);">
                        <p class="text-[10px] pm-mono" style="color:var(--t1);">
                            <span style="color:var(--red);">*</span> Required fields
                        </p>
                        <div class="flex items-center gap-2.5">
                            <button wire:click="closeModal"
                                class="px-5 py-2 rounded-xl text-sm font-medium transition"
                                style="color:var(--t3);border:1px solid var(--line2);"
                                onmouseover="this.style.color='var(--t1)';this.style.borderColor='var(--t3)'"
                                onmouseout="this.style.color='var(--t3)';this.style.borderColor='var(--line2)'">
                                Cancel
                            </button>
                            <button wire:click="save"
                                class="flex items-center gap-2 px-6 py-2 rounded-xl text-sm font-semibold transition-all"
                                style="background:var(--cyan);color:var(--bg0);box-shadow:0 0 16px rgba(34,211,238,.2);"
                                onmouseover="this.style.boxShadow='0 0 24px rgba(34,211,238,.4)'"
                                onmouseout="this.style.boxShadow='0 0 16px rgba(34,211,238,.2)'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    @if($editingId)
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
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
        @if($showDelete)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background:rgba(2,5,14,.9);backdrop-filter:blur(12px);">
                <div class="pm-modal-in w-full max-w-sm rounded-2xl p-8 space-y-5 text-center"
                    style="background:var(--bg1);border:1px solid var(--line2);box-shadow:0 40px 100px rgba(0,0,0,.8);">

                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto"
                        style="background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" style="color:var(--red);" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-bold" style="color:var(--t1);font-size:1rem;">Delete Project?</h3>
                        <p class="text-sm mt-2 leading-relaxed" style="color:var(--t3);">
                            This action cannot be undone.<br>The thumbnail will also be permanently removed.
                        </p>
                    </div>

                    <div class="flex justify-center gap-3 pt-1">
                        <button wire:click="closeModal"
                            class="px-6 py-2 rounded-xl text-sm font-medium transition"
                            style="color:var(--t3);border:1px solid var(--line2);"
                            onmouseover="this.style.color='var(--t1)';this.style.borderColor='var(--t3)'"
                            onmouseout="this.style.color='var(--t3)';this.style.borderColor='var(--line2)'">
                            Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-6 py-2 rounded-xl text-sm font-semibold transition"
                            style="background:rgba(248,113,113,.15);color:var(--red);border:1px solid rgba(248,113,113,.35);"
                            onmouseover="this.style.background='rgba(248,113,113,.25)'"
                            onmouseout="this.style.background='rgba(248,113,113,.15)'">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>
    </div>

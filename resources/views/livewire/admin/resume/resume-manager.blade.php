<div class="max-w-2xl space-y-8">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-white">Resume / CV</h2>
        <p class="text-sm text-slate-400 mt-1">PDF available for download on your portfolio</p>
    </div>


    {{-- FLASH / ERRORS --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="px-4 py-3 rounded-lg text-xs font-mono border border-cyan-400/20 bg-cyan-400/10 text-cyan-300">
            {{ session('success') }}
        </div>
    @endif

    @if ($error)
        <div class="px-4 py-3 rounded-lg text-xs font-mono border border-red-500/20 bg-red-500/10 text-red-400">
            {{ $error }}
        </div>
    @endif


    {{-- UPLOAD --}}
    <div class="card p-6 space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">Upload New Resume</h3>

        <div class="border-2 border-dashed border-slate-700 rounded-xl p-8 text-center hover:border-cyan-400/50 transition">
            <input wire:model="pdf" type="file" accept=".pdf" id="resume-input" class="hidden">
            <label for="resume-input" class="cursor-pointer space-y-3 block">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-slate-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                </svg>
                <p class="text-sm text-slate-400">
                    @if ($pdf)
                        <span class="text-cyan-400 font-semibold">{{ $pdf->getClientOriginalName() }}</span>
                    @else
                        <span>Drop PDF here or <span class="text-cyan-400">browse</span></span>
                    @endif
                </p>
                <p class="text-xs text-slate-600">PDF only · Max 5MB</p>
            </label>
        </div>

        @error('pdf') <p class="text-xs text-red-400">{{ $message }}</p> @enderror

        @if ($pdf)
            <div class="flex justify-end">
                <button wire:click="upload" class="btn-primary px-6 py-2">
                    Upload & Activate
                </button>
            </div>
        @endif
    </div>


    {{-- EXISTING RESUMES --}}
    @if ($resumes->isNotEmpty())
        <div class="card p-6 space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-widest text-cyan-400">Uploaded Resumes</h3>

            <div class="space-y-3">
                @foreach ($resumes as $resume)
                    <div class="flex items-center justify-between gap-4 p-4 rounded-lg border {{ $resume->is_active ? 'border-cyan-400/40 bg-cyan-400/5' : 'border-slate-700 bg-[#080a14]' }}">

                        <div class="flex items-center gap-3 min-w-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                            <div class="min-w-0">
                                <p class="text-sm text-slate-200 truncate">{{ $resume->filename }}</p>
                                <p class="text-xs text-slate-500">{{ $resume->size_kb }} KB · {{ $resume->created_at ? (\Carbon\Carbon::parse($resume->created_at)->format('M d, Y')) : '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">

                            @if ($resume->is_active)
                                <span class="text-xs px-2 py-1 rounded-full bg-cyan-400/10 text-cyan-400 border border-cyan-400/20 font-mono">
                                    Active
                                </span>
                            @else
                                <button wire:click="activate({{ $resume->id }})"
                                    class="text-xs px-3 py-1 rounded-lg border border-slate-600 text-slate-400 hover:border-cyan-400 hover:text-cyan-400 transition">
                                    Set Active
                                </button>
                            @endif

                            <a href="{{ str_starts_with($resume->path, 'http') ? $resume->path : Storage::disk('r2')->url($resume->path) }}" target="_blank"
                                class="p-1.5 text-slate-400 hover:text-cyan-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                </svg>
                            </a>

                            <button wire:click="delete({{ $resume->id }})"
                                wire:confirm="Delete this resume?"
                                class="p-1.5 text-slate-500 hover:text-red-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

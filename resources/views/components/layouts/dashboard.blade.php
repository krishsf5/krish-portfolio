<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        dark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    }"
    x-init="
        $watch('dark', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
            val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
        });
        if (dark) document.documentElement.classList.add('dark');
    "
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen transition-colors duration-200 bg-gray-50 dark:bg-[#080a14] text-slate-800 dark:text-slate-200">

    <header class="sticky top-0 z-50 border-b transition-colors bg-white dark:bg-[#0c0f1e] border-slate-200 dark:border-[#19243a]">
        <div class="max-w-screen-xl mx-auto px-6 h-14 flex items-center gap-4">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="font-mono font-semibold text-base tracking-wider text-cyan-500 dark:text-cyan-400 shrink-0 no-underline">
                folio<span class="text-orange-400">.</span>cms
            </a>

            {{-- Nav Links --}}
            <nav class="flex items-center gap-1 flex-1">
                @php
                    $navItems = [
                        'dashboard'        => ['label' => 'Projects',  'path' => 'dashboard'],
                        'skills'           => ['label' => 'Skills',    'path' => 'dashboard/skills'],
                        'about'            => ['label' => 'About Me',  'path' => 'dashboard/about'],
                        'resume'           => ['label' => 'Resume',    'path' => 'dashboard/resume'],
                    ];
                @endphp

                @foreach ($navItems as $route => $item)
                    @php $isActive = request()->is($item['path']); @endphp
                    <a href="{{ route($route) }}"
                       class="px-3.5 py-1.5 rounded-lg text-xs font-mono tracking-wide border transition-all cursor-pointer
                              {{ $isActive
                                  ? 'text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-950/30 border-cyan-200 dark:border-cyan-900/60'
                                  : 'text-slate-400 dark:text-slate-500 bg-transparent border-transparent hover:text-slate-700 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-3">

                {{-- Dark mode toggle --}}
                <button
                    @click="dark = !dark"
                    title="Toggle theme"
                    class="relative flex-shrink-0 w-9 h-5 rounded-full border-0 cursor-pointer transition-colors duration-200 focus:outline-none"
                    :style="dark ? 'background:#22d3ee' : 'background:#cbd5e1'"
                >
                    <span
                        class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 block"
                        :style="dark ? 'transform:translateX(16px)' : 'transform:translateX(2px)'"
                    ></span>
                </button>

                {{-- View Portfolio --}}
                <a href="{{ route('home') }}" target="_blank"
                   class="text-[10px] font-mono font-semibold tracking-wide px-3 py-1.5 rounded-md border cursor-pointer transition-all
                          text-slate-500 dark:text-slate-400 border-slate-200 dark:border-white/10
                          hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-white/20">
                    View Portfolio ↗
                </a>

                {{-- Avatar / Logout --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="w-8 h-8 rounded-full border cursor-pointer transition-colors font-mono text-xs font-semibold flex items-center justify-center
                               bg-cyan-500/10 dark:bg-cyan-400/10 border-cyan-500/30 dark:border-cyan-400/30
                               text-cyan-600 dark:text-cyan-400 hover:bg-cyan-500/20"
                    >
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </button>

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 top-10 w-44 rounded-xl shadow-lg py-1.5 z-50 border
                               bg-white dark:bg-[#0c1120] border-slate-200 dark:border-[#19243a]"
                    >
                        <div class="px-3 py-2 border-b border-slate-100 dark:border-[#19243a]">
                            <p class="text-xs font-mono text-slate-800 dark:text-slate-200 truncate">{{ auth()->user()->name ?? '' }}</p>
                            <p class="text-[10px] font-mono text-slate-400 dark:text-slate-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-3 py-2 text-xs font-mono text-red-400 cursor-pointer bg-transparent border-0
                                       hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <main class="max-w-screen-xl mx-auto px-6 py-8">
        {{ $slot }}
    </main>

</body>
</html>

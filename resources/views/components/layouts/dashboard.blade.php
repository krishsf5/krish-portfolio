<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        dark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    }"
    x-init="
        $watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'));
        if (dark) document.documentElement.classList.add('dark');
    "
    x-bind:class="{ 'dark': dark }"
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
    @fluxStyles
</head>
<body class="min-h-screen bg-gray-50 dark:bg-navy-950 transition-colors duration-200">

    {{-- Top Navigation --}}
    <header class="sticky top-0 z-50 bg-white dark:bg-navy-900 border-b border-slate-200 dark:border-navy-600 transition-colors">
        <div class="max-w-screen-xl mx-auto px-6 h-14 flex items-center gap-6">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="font-mono font-semibold text-base tracking-wider text-cyan-500 dark:text-cyan-400 shrink-0">
                folio<span class="text-orange-400">.</span>cms
            </a>

            {{-- Nav Links --}}
            <nav class="flex items-center gap-1 flex-1">
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link' }}">
                    Projects
                </a>
                <a href="{{ route('skills') }}"
                   class="{{ request()->routeIs('skills') ? 'nav-link-active' : 'nav-link' }}">
                    Skills
                </a>
                <a href="{{ route('about') }}"
                   class="{{ request()->routeIs('about') ? 'nav-link-active' : 'nav-link' }}">
                    About Me
                </a>
                <a href="{{ route('resume') }}"
                   class="{{ request()->routeIs('resume') ? 'nav-link-active' : 'nav-link' }}">
                    Resume
                </a>
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-3">

                {{-- Dark mode toggle --}}
                <button
                    @click="dark = !dark"
                    class="w-9 h-5 rounded-full relative transition-colors duration-200 focus:outline-none border-0 cursor-pointer"
                    x-bind:class="dark ? 'bg-cyan-500' : 'bg-slate-200'"
                    title="Toggle theme"
                >
                    <span
                        class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"
                        x-bind:class="dark ? 'translate-x-4' : 'translate-x-0.5'"
                    ></span>
                </button>

                {{-- View Portfolio --}}
                <a href="{{ route('portfolio') }}" target="_blank"
                   class="btn-ghost text-[10px] px-3 py-1.5">
                    View Portfolio ↗
                </a>

                {{-- Avatar / Logout --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="w-8 h-8 rounded-full bg-cyan-500/10 dark:bg-cyan-400/10 border border-cyan-500/30 dark:border-cyan-400/30 text-cyan-600 dark:text-cyan-400 font-mono text-xs font-semibold flex items-center justify-center cursor-pointer hover:bg-cyan-500/20 transition-colors"
                    >
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </button>
                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 top-10 w-44 bg-white dark:bg-navy-800 border border-slate-200 dark:border-navy-600 rounded-xl shadow-lg py-1.5 z-50"
                    >
                        <div class="px-3 py-2 border-b border-slate-100 dark:border-navy-600">
                            <p class="text-xs font-mono text-slate-800 dark:text-slate-200 truncate">{{ auth()->user()->name ?? '' }}</p>
                            <p class="text-[10px] font-mono text-slate-400 dark:text-navy-300 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-xs font-mono text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="max-w-screen-xl mx-auto px-6 py-8">
        {{ $slot }}
    </main>

    @fluxScripts
</body>
</html>

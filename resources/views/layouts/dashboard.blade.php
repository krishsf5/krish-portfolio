<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ theme: localStorage.getItem('theme') || 'dark' }"
    x-init="
        if (theme === 'dark') {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    "
    class="scroll-smooth"
>
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="dashboard min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#080a14] dark:text-white antialiased">
        <x-global-loader />

        <div class="relative flex min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#080a14] dark:text-white overflow-hidden">

            {{-- Ambient background atmosphere glow --}}
            <div aria-hidden="true" class="pointer-events-none fixed inset-0 z-0">
                <div class="absolute -top-40 right-10 w-[550px] h-[550px] rounded-full bg-cyan-500/5 blur-[160px]"></div>
                <div class="absolute -bottom-40 left-60 w-[500px] h-[500px] rounded-full bg-indigo-500/5 blur-[160px]"></div>
            </div>

            {{-- Sidebar --}}
            <aside class="relative z-10 w-64 border-r border-slate-200/80 bg-white/80 backdrop-blur-xl flex flex-col justify-between transition-colors duration-300 dark:border-slate-800/80 dark:bg-[#0c1120]/85">
                <div>
                    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-200/80 transition-colors duration-300 dark:border-slate-800/80">
                        <a href="/" wire:navigate class="text-cyan-600 dark:text-cyan-400 font-bold text-lg hover:opacity-80 transition tracking-tight">
                            Portfolio CMS
                        </a>
                        <a href="/" wire:navigate title="View Public Site" class="text-xs text-slate-400 hover:text-cyan-400 transition font-mono px-2 py-1 rounded border border-slate-200 dark:border-slate-800 hover:border-cyan-400/50">
                            Site ↗
                        </a>
                    </div>

                    <nav class="px-4 py-6 space-y-1.5 font-mono text-sm">
                        @php
                            $links = [
                                ['url' => '/dashboard', 'route' => 'dashboard', 'label' => 'Projects', 'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z'],
                                ['url' => '/dashboard/skills', 'route' => 'skills', 'label' => 'Skills', 'icon' => 'M11.42 15.17 17.25 21A2.67 2.67 0 0 0 21 17.25l-5.83-5.83M11.42 15.17l2.496-3.03c.315-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 3.256'],
                                ['url' => '/dashboard/about', 'route' => 'about', 'label' => 'About Profile', 'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
                                ['url' => '/dashboard/resume', 'route' => 'resume', 'label' => 'Resume', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z'],
                                ['url' => route('inquiries'), 'route' => 'inquiries', 'label' => 'Inquiries', 'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75'],
                            ];
                        @endphp

                        @foreach ($links as $link)
                            @php $active = request()->routeIs($link['route']); @endphp
                            <a href="{{ $link['url'] }}" wire:navigate
                               class="group relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ $active ? 'bg-cyan-500/15 text-cyan-400 font-semibold border border-cyan-400/30 shadow-[0_0_12px_rgba(34,211,238,0.15)]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:scale-110 {{ $active ? 'text-cyan-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-cyan-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                                </svg>
                                <span>{{ $link['label'] }}</span>
                                @if ($active)
                                    <span class="absolute right-2.5 w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_8px_#22d3ee]"></span>
                                @endif
                            </a>
                        @endforeach
                    </nav>
                </div>

                {{-- User / Logout --}}
                <div class="p-4 border-t border-slate-200/80 dark:border-slate-800/80">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-mono text-red-500 dark:text-red-400 hover:bg-red-500/10 hover:border-red-500/20 border border-transparent transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </aside>

            <div class="relative z-10 flex-1 flex flex-col min-w-0">
                <header class="h-16 border-b border-slate-200/80 bg-white/70 backdrop-blur-xl flex items-center justify-between px-8 transition-colors duration-300 dark:border-slate-800/80 dark:bg-[#0c1120]/75">
                    <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $title ?? 'Dashboard' }}
                    </h2>

                    <div class="flex items-center gap-6">
                        <button
                            x-data
                            @click="
                                theme = theme === 'dark' ? 'light' : 'dark';
                                localStorage.setItem('theme', theme);
                                document.documentElement.classList.toggle('dark', theme === 'dark');
                            "
                            class="toggle-glow relative inline-flex h-9 w-16 items-center rounded-full border border-slate-300 bg-slate-200 transition-all duration-300 dark:border-slate-700 dark:bg-slate-800 cursor-pointer"
                            :aria-pressed="theme === 'dark'"
                        >
                            <span
                                class="absolute left-1 flex h-7 w-7 items-center justify-center rounded-full bg-white shadow-md transition-all duration-300 dark:bg-cyan-400"
                                :class="theme === 'dark' ? 'translate-x-7' : 'translate-x-0'"
                            >
                                <svg
                                    x-show="theme === 'light'"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-slate-700"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="12" cy="12" r="4"/>
                                    <path d="M12 2v2M12 20v2M4.93 4.93l1.4 1.4M17.66 17.66l1.4 1.4M2 12h2M20 12h2M4.93 19.07l1.4-1.4M17.66 6.34l1.4-1.4"/>
                                </svg>

                                <svg
                                    x-show="theme === 'dark'"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-[#080a14]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto px-10 py-6 scroll-smooth">
                    <div class="slide-up">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @livewireScripts
        @fluxScripts
    </body>
</html>

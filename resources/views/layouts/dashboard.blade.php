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
>
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="dashboard min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#080a14] dark:text-white">
        <div class="flex min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#080a14] dark:text-white">
            <aside class="w-64 border-r border-slate-200 bg-white/80 flex flex-col transition-colors duration-300 dark:border-slate-800 dark:bg-[#0c1120]">
                <div class="h-16 flex items-center px-6 border-b border-slate-200 transition-colors duration-300 dark:border-slate-800">
                    <h1 class="text-cyan-400 font-semibold text-lg">
                        Portfolio CMS
                    </h1>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2">

                    <a href="/dashboard"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                        Dashboard
                    </a>

                    <a href="/dashboard/skills"
                       class="nav-link {{ request()->routeIs('skills') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                        Skills
                    </a>

                    <a href="/dashboard/about"
                       class="nav-link {{ request()->routeIs('about') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                        About
                    </a>

                    <a href="/dashboard/resume"
                       class="nav-link {{ request()->routeIs('resume') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                        Resume
                    </a>

                    <a href="{{ route('inquiries') }}"
                       class="nav-link {{ request()->routeIs('inquiries') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                        Inquiries
                    </a>

                    <div class="pt-6 mt-6 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('profile.edit') }}"
                           class="nav-link {{ request()->routeIs('profile.edit') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                            Profile
                        </a>

                        <a href="{{ route('security.edit') }}"
                           class="nav-link {{ request()->routeIs('security.edit') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                            Security
                        </a>

                        <a href="{{ route('appearance.edit') }}"
                           class="nav-link {{ request()->routeIs('appearance.edit') ? 'bg-slate-200 text-cyan-400 dark:bg-slate-800' : '' }}">
                            Appearance
                        </a>
                    </div>

                </nav>
            </aside>

            <div class="flex-1 flex flex-col">
                <header class="h-16 border-b border-slate-200 bg-white/70 flex items-center justify-between px-8 transition-colors duration-300 dark:border-slate-800 dark:bg-[#0c1120]">
                    <h2 class="text-lg font-semibold">
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
                            class="toggle-glow relative inline-flex h-9 w-16 items-center rounded-full border border-slate-300 bg-slate-200 transition-all duration-300 dark:border-slate-700 dark:bg-slate-800"
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

                <main class="flex-1 overflow-y-auto px-10 py-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
        @fluxScripts
    </body>
</html>

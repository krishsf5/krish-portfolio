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
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#080a14] dark:text-white">
        <div class="flex min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#080a14] dark:text-white">
            <aside class="w-64 border-r border-slate-200 bg-white/80 flex flex-col transition-colors duration-300 dark:border-slate-800 dark:bg-[#0c1120]">
                <div class="h-16 flex items-center px-6 border-b border-slate-200 transition-colors duration-300 dark:border-slate-800">
                    <h1 class="text-cyan-400 font-semibold text-lg">
                        Portfolio CMS
                    </h1>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="/dashboard" class="nav-link">Dashboard</a>
                    <a href="/dashboard/skills" class="nav-link">Skills</a>
                    <a href="/dashboard/about" class="nav-link">About</a>
                    <a href="/dashboard/resume" class="nav-link">Resume</a>
                </nav>
            </aside>

            <div class="flex-1 flex flex-col">
                <header class="h-16 border-b border-slate-200 bg-white/70 flex items-center justify-between px-8 transition-colors duration-300 dark:border-slate-800 dark:bg-[#0c1120]">
                    <h2 class="text-lg font-semibold">
                        {{ $title ?? 'Dashboard' }}
                    </h2>

                    <div class="flex items-center gap-6">
                        <button
                            type="button"
                            :aria-pressed="theme === 'dark'"
                            :title="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
                            class="relative inline-flex h-10 w-20 items-center rounded-full border border-slate-300 bg-slate-200 px-1 transition-all duration-300 dark:border-slate-700 dark:bg-slate-800"
                            @click="
                                theme = theme === 'dark' ? 'light' : 'dark';
                                localStorage.setItem('theme', theme);

                                if (theme === 'dark') {
                                    document.documentElement.classList.add('dark')
                                } else {
                                    document.documentElement.classList.remove('dark')
                                }
                            "
                        >
                            <span
                                class="absolute inset-y-1 left-1 flex w-8 items-center justify-center rounded-full bg-white text-slate-700 shadow-sm transition-all duration-300 dark:bg-cyan-400 dark:text-[#080a14]"
                                :class="theme === 'dark' ? 'translate-x-10' : 'translate-x-0'"
                            >
                                <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="4"></circle>
                                    <path d="M12 2v2.5M12 19.5V22M4.93 4.93l1.77 1.77M17.3 17.3l1.77 1.77M2 12h2.5M19.5 12H22M4.93 19.07l1.77-1.77M17.3 6.7l1.77-1.77"></path>
                                </svg>
                                <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"></path>
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

        @fluxScripts
    </body>
</html>

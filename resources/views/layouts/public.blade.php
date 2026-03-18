<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ theme: localStorage.getItem('theme') || 'dark' }" x-init="document.documentElement.classList.toggle('dark', theme === 'dark')">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Krish Bhojwani' }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.16.0/devicon.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body class="bg-slate-50 text-slate-900 dark:bg-[#080a14] dark:text-slate-200 transition-colors duration-300">

    <div class="min-h-screen flex flex-col">

        <header class="border-b border-slate-200 dark:border-slate-800 backdrop-blur">

            <div class="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">

                <h1 class="text-cyan-600 dark:text-cyan-400 font-semibold text-lg">
                    Krish.dev
                </h1>

                <nav class="flex items-center gap-10 text-sm font-mono">

                    <a href="#projects"
                        class="text-slate-700 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition">
                        Projects
                    </a>

                    <a href="#skills"
                        class="text-slate-700 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition">
                        Skills
                    </a>

                    <a href="#about"
                        class="text-slate-700 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition">
                        About
                    </a>

                </nav>


                <div class="flex items-center gap-6">

                    <button
                        @click="
theme = theme === 'dark' ? 'light' : 'dark';
localStorage.setItem('theme', theme);
document.documentElement.classList.toggle('dark', theme === 'dark');
"
                        class="toggle-glow relative inline-flex h-9 w-16 items-center rounded-full border border-slate-300 bg-slate-200 transition-all duration-300 dark:border-slate-700 dark:bg-slate-800">

                        <span
                            class="absolute left-1 flex h-7 w-7 items-center justify-center rounded-full bg-white shadow-md transition-all duration-300 dark:bg-cyan-400"
                            :class="theme === 'dark' ? 'translate-x-7' : 'translate-x-0'">

                            <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">

                                <circle cx="12" cy="12" r="4" />
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.4 1.4M17.66 17.66l1.4 1.4M2 12h2M20 12h2" />

                            </svg>

                            <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-[#080a14]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">

                                <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />

                            </svg>

                        </span>

                    </button>

                </div>

            </div>

        </header>


        <main class="flex-1">

            {{ $slot }}

        </main>


        <footer
            class="border-t border-slate-200 dark:border-slate-800 text-center py-8 text-slate-500 dark:text-slate-400 text-sm">

            © {{ date('Y') }} Krish Bhojwani

        </footer>

    </div>

    @livewireScripts

</body>

</html>

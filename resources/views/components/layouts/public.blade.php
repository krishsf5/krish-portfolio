<!DOCTYPE html>
<html lang="en" x-data="{ theme: localStorage.getItem('theme') || 'dark' }" x-init="if (theme === 'dark') {
    document.documentElement.classList.add('dark')
}">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
    <meta charset="UTF-8">

    <title>{{ $title ?? 'Krish Bhojwani' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>


<body class="bg-white dark:bg-[#080a14] text-white">

    <div class="min-h-screen flex flex-col">

        <header class="border-b border-slate-200 dark:border-slate-800 backdrop-blur">

            <div class="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">

                <h1 class="text-cyan-400 font-semibold text-lg">
                    Krish.dev
                </h1>


                <nav class="flex items-center gap-10 text-sm font-mono">

                    <a href="#projects" class="nav-link  text-[#080a14]">
                        Projects
                    </a>

                    <a href="#skills" class="nav-link  text-[#080a14]">
                        Skills
                    </a>

                    <a href="#about" class="nav-link  text-[#080a14]">
                        About
                    </a>

                </nav>


                <div class="flex items-center gap-6">

                    <button x-data
                        @click="
            theme = theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
            "
                        class="toggle-glow relative inline-flex h-9 w-16 items-center rounded-full border border-slate-300 bg-slate-200 transition-all duration-300 dark:border-slate-700 dark:bg-slate-800"
                        :aria-pressed="theme === 'dark'">

                        <span
                            class="absolute left-1 flex h-7 w-7 items-center justify-center rounded-full bg-white shadow-md transition-all duration-300 dark:bg-cyan-400"
                            :class="theme === 'dark' ? 'translate-x-7' : 'translate-x-0'">

                            <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <circle cx="12" cy="12" r="4" />
                                <path
                                    d="M12 2v2M12 20v2M4.93 4.93l1.4 1.4M17.66 17.66l1.4 1.4M2 12h2M20 12h2M4.93 19.07l1.4-1.4M17.66 6.34l1.4-1.4" />
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


        <footer class="border-t border-slate-800 text-center py-8 text-slate-400 text-sm">

            © {{ date('Y') }} Krish Bhojwani

        </footer>

    </div>

    @livewireScripts

</body>

</html>

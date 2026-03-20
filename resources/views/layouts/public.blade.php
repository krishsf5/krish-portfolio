<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ theme: localStorage.getItem('theme') || 'dark' }" x-init="document.documentElement.classList.toggle('dark', theme === 'dark')">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Krish Bhojwani' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.16.0/devicon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="bg-slate-50 text-slate-900 dark:bg-[#080a14] dark:text-slate-200 transition-colors duration-300">
    <!-- SCROLL PROGRESS BAR -->
    <div id="scroll-progress"
        class="fixed top-0 left-0 h-[2px] bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 z-[999]"
        style="width:0%"></div>
    <div class="min-h-screen flex flex-col">

        <header id="main-nav"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-transparent">
            <div class="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">
                <a href="/"
                    class="text-cyan-600 dark:text-cyan-400 font-semibold text-lg tracking-tight hover:opacity-80 transition">Krish.dev</a>
                <nav class="hidden md:flex items-center gap-10 text-sm font-mono">
                    <a href="#projects" data-nav-link="projects"
                        class="nav-section-link text-slate-600 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition-colors relative">
                        Projects
                        <span
                            class="nav-underline absolute -bottom-0.5 left-0 h-px bg-cyan-400 w-0 transition-all duration-300"></span>
                    </a>
                    <a href="#skills" data-nav-link="skills"
                        class="nav-section-link text-slate-600 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition-colors relative">
                        Skills
                        <span
                            class="nav-underline absolute -bottom-0.5 left-0 h-px bg-cyan-400 w-0 transition-all duration-300"></span>
                    </a>
                    <a href="#about" data-nav-link="about"
                        class="nav-section-link text-slate-600 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition-colors relative">
                        About
                        <span
                            class="nav-underline absolute -bottom-0.5 left-0 h-px bg-cyan-400 w-0 transition-all duration-300"></span>
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


        <main class="pt-16">

            {{ $slot }}

        </main>


        <footer class="border-t border-slate-200 dark:border-slate-800 py-12 mt-20">
            <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-mono">
                    © {{ date('Y') }} Krish Bhojwani — Built with Laravel + Livewire
                </p>
                <div class="flex items-center gap-6 text-sm text-slate-500 dark:text-slate-400">
                    <a href="https://gitlab.com/krishtbhojwani" target="_blank" class="hover:text-cyan-400 transition">GitLab</a>
                    <a href="https://linkedin.com/in/krish-bhojwani" target="_blank" class="hover:text-cyan-400 transition">LinkedIn</a>
                    <a href="mailto:krishtbhojwani@gmail.com" class="hover:text-cyan-400 transition">Email</a>
                </div>
            </div>
        </footer>

    </div>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @livewireScripts
    <script>
        const nav = document.getElementById('main-nav')
        const progressBar = document.getElementById('scroll-progress')

        window.addEventListener('scroll', () => {
            const pct = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
            progressBar.style.width = Math.min(pct, 100) + '%'

            nav.classList.toggle('nav-scrolled', window.scrollY > 40)

            let current = '';
            ['projects', 'skills', 'about'].forEach(id => {
                const el = document.getElementById(id)
                if (el && window.scrollY >= el.offsetTop - 140) current = id
            })
            document.querySelectorAll('[data-nav-link]').forEach(link => {
                const underline = link.querySelector('.nav-underline')
                const active = link.dataset.navLink === current
                link.classList.toggle('!text-cyan-400', active)
                if (underline) underline.style.width = active ? '100%' : '0'
            })
        }, {
            passive: true
        })
    </script>

</body>

</html>

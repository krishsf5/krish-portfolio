]
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ theme: localStorage.getItem('theme') || 'dark' }" x-init="document.documentElement.classList.toggle('dark', theme === 'dark')">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Krish Bhojwani' }}</title>
    <link rel="icon" href="{{ asset('images/profile.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/profile.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.16.0/devicon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        html {
            scroll-behavior: smooth;
        }

        section[id] {
            scroll-margin-top: 72px;
        }

        /* Nav scrolled state */
        .nav-scrolled {
            background: rgba(248, 250, 252, 0.9) !important;
            backdrop-filter: blur(12px);
            border-color: rgba(148, 163, 184, 0.2) !important;
        }

        .dark .nav-scrolled {
            background: rgba(8, 10, 20, 0.88) !important;
            border-color: rgba(148, 163, 184, 0.1) !important;
        }

        /* Active nav link */
        .nav-section-link.is-active {
            color: #22d3ee !important;
        }

        .nav-section-link.is-active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 1.5px;
            background: #22d3ee;
            border-radius: 2px;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 dark:bg-[#080a14] dark:text-slate-200 transition-colors duration-300">

    {{-- Scroll progress bar --}}
    <div id="scroll-progress"
        class="fixed top-0 left-0 h-[2px] bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 z-[999]"
        style="width:0%"></div>

    <div class="min-h-screen flex flex-col">

        {{-- NAV --}}
        <header id="main-nav"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-transparent">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

                {{-- Logo --}}
                <a href="/"
                    class="flex items-center gap-3 text-cyan-600 dark:text-cyan-400 font-semibold text-lg tracking-tight hover:opacity-80 transition">
                    <img src="{{ asset('images/profile.png') }}" alt="Krish Bhojwani"
                        class="h-9 w-9 rounded-md object-cover">
                    Krish.dev
                </a>

                {{-- Desktop nav links --}}
                {{--
                    Smart links: on homepage use anchor (#projects),
                    on any other page (e.g. project detail) go back to homepage first (/#projects).
                --}}
                @php $onHome = request()->is('/'); @endphp
                <nav class="hidden md:flex items-center gap-10 text-sm font-mono">
                    @foreach ([
        'projects' => 'Projects',
        'skills' => 'Skills',
        'about' => 'About',
        'contact' => 'Contact',
    ] as $id => $label)
                        <a href="{{ $onHome ? '#' . $id : '/#' . $id }}" data-nav-link="{{ $id }}"
                            class="nav-section-link relative text-slate-600 hover:text-cyan-600 dark:text-slate-300 dark:hover:text-cyan-400 transition-colors duration-200">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>

                {{-- Mobile hamburger --}}
                <button id="mobile-menu-btn"
                    class="md:hidden flex flex-col gap-1.5 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                    aria-label="Toggle menu">
                    <span
                        class="mobile-bar block h-0.5 w-5 bg-slate-600 dark:bg-slate-300 transition-all duration-300"></span>
                    <span
                        class="mobile-bar block h-0.5 w-5 bg-slate-600 dark:bg-slate-300 transition-all duration-300"></span>
                    <span
                        class="mobile-bar block h-0.5 w-5 bg-slate-600 dark:bg-slate-300 transition-all duration-300"></span>
                </button>

                {{-- Right side controls --}}
                <div class="hidden md:flex items-center gap-6">
                    {{-- Dark/light toggle --}}
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

            {{-- Mobile dropdown menu --}}
            <div id="mobile-menu"
                class="md:hidden hidden border-t border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-[#080a14]/95 backdrop-blur-md">
                <nav class="flex flex-col px-5 sm:px-6 py-4 gap-1 font-mono text-sm">
                    @foreach ([
        'projects' => 'Projects',
        'skills' => 'Skills',
        'about' => 'About',
        'contact' => 'Contact',
    ] as $id => $label)
                        <a href="{{ $onHome ? '#' . $id : '/#' . $id }}" data-mobile-nav-link="{{ $id }}"
                            class="mobile-nav-link py-3 px-2 rounded-lg text-slate-600 dark:text-slate-300 hover:text-cyan-500 dark:hover:text-cyan-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-100 dark:border-slate-800/50 last:border-0">
                            <span class="mr-2 text-cyan-400 opacity-60">—</span>{{ $label }}
                        </a>
                    @endforeach

                    {{-- Mobile theme toggle --}}
                    <div class="pt-3 flex items-center justify-between">
                        <span class="text-slate-400 text-xs">Theme</span>
                        <button
                            @click="
                                theme = theme === 'dark' ? 'light' : 'dark';
                                localStorage.setItem('theme', theme);
                                document.documentElement.classList.toggle('dark', theme === 'dark');
                            "
                            class="relative inline-flex h-8 w-14 items-center rounded-full border border-slate-300 bg-slate-200 dark:border-slate-700 dark:bg-slate-800 transition-all duration-300">
                            <span
                                class="absolute left-1 flex h-6 w-6 items-center justify-center rounded-full bg-white shadow dark:bg-cyan-400 transition-all duration-300"
                                :class="theme === 'dark' ? 'translate-x-6' : 'translate-x-0'">
                                <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5 text-slate-700" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="4" />
                                    <path d="M12 2v2M12 20v2M4.93 4.93l1.4 1.4M17.66 17.66l1.4 1.4M2 12h2M20 12h2" />
                                </svg>
                                <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5 text-[#080a14]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </nav>
            </div>
        </header>

        {{-- Main content --}}
        <main class="pt-16">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t border-slate-200 dark:border-slate-800 py-12 mt-20">
            <div
                class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
                <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-mono">
                    © {{ date('Y') }} Krish Bhojwani — Built with Laravel + Livewire
                </p>
                <div
                    class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-slate-500 dark:text-slate-400">
                    <a href="https://gitlab.com/krishtbhojwani" target="_blank"
                        class="hover:text-cyan-400 transition">GitLab</a>
                    <a href="https://linkedin.com/in/krish-bhojwani" target="_blank"
                        class="hover:text-cyan-400 transition">LinkedIn</a>
                    <a href="mailto:krishtbhojwani@gmail.com" class="hover:text-cyan-400 transition">Email</a>
                </div>
            </div>
        </footer>

    </div>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @livewireScripts

    <script>
        (() => {
            const nav = document.getElementById('main-nav')
            const progressBar = document.getElementById('scroll-progress')
            const mobileBtn = document.getElementById('mobile-menu-btn')
            const mobileMenu = document.getElementById('mobile-menu')

            // ── Scroll progress ───────────────────────────────────────
            function updateProgress() {
                const max = document.documentElement.scrollHeight - window.innerHeight
                progressBar.style.width = max > 0 ?
                    Math.min((window.scrollY / max) * 100, 100) + '%' :
                    '0%'
            }

            // ── Nav background on scroll ──────────────────────────────
            function updateNavBg() {
                nav.classList.toggle('nav-scrolled', window.scrollY > 40)
            }

            // ── Scroll spy (homepage only) ────────────────────────────
            // Only runs on homepage where the sections actually exist.
            const isHomePage = window.location.pathname === '/'
            const navLinks = document.querySelectorAll('[data-nav-link]')

            function updateActiveNav() {
                if (!isHomePage) return
                const sections = document.querySelectorAll('section[id]')
                let current = ''
                sections.forEach(section => {
                    if (window.scrollY >= section.offsetTop - 120) {
                        current = section.id
                    }
                })
                navLinks.forEach(link => {
                    link.classList.toggle('is-active', link.dataset.navLink === current)
                })
            }

            window.addEventListener('scroll', () => {
                updateProgress()
                updateNavBg()
                updateActiveNav()
            }, {
                passive: true
            })

            updateProgress()
            updateNavBg()
            updateActiveNav()

            // ── Mobile menu ───────────────────────────────────────────
            if (!mobileBtn || !mobileMenu) return

            let mobileOpen = false

            function closeMobile() {
                mobileOpen = false
                mobileMenu.classList.add('hidden')
                const bars = mobileBtn.querySelectorAll('.mobile-bar')
                bars[0].style.transform = ''
                bars[1].style.opacity = ''
                bars[2].style.transform = ''
            }

            function openMobile() {
                mobileOpen = true
                mobileMenu.classList.remove('hidden')
                const bars = mobileBtn.querySelectorAll('.mobile-bar')
                bars[0].style.transform = 'translateY(8px) rotate(45deg)'
                bars[1].style.opacity = '0'
                bars[2].style.transform = 'translateY(-8px) rotate(-45deg)'
            }

            mobileBtn.addEventListener('click', e => {
                e.stopPropagation()
                mobileOpen ? closeMobile() : openMobile()
            })

            document.querySelectorAll('[data-mobile-nav-link]').forEach(link => {
                link.addEventListener('click', closeMobile)
            })

            document.addEventListener('click', e => {
                if (mobileOpen && !nav.contains(e.target)) closeMobile()
            })
        })()
    </script>

</body>

</html>

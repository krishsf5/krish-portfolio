<div class="relative min-h-[calc(100svh-4rem)] flex items-start overflow-hidden pt-12 sm:pt-16 md:pt-20 pb-8 sm:pb-10">

    <!-- BACKGROUND LAYERS -->
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <!-- Grid pattern -->
        <div class="absolute inset-0 grid-pattern opacity-20"></div>

        <!-- Ambient static gradient lights (no flicker, smooth & performant) -->
        <div class="absolute w-[650px] h-[650px] rounded-full top-[-150px] left-[-150px]"
             style="background: radial-gradient(circle, rgba(34,211,238,0.12) 0%, transparent 70%);"></div>
        <div class="absolute w-[600px] h-[600px] rounded-full bottom-[-100px] right-[-100px]"
             style="background: radial-gradient(circle, rgba(99,102,241,0.10) 0%, transparent 70%);"></div>
    </div>


    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 w-full grid md:grid-cols-2 gap-10 md:gap-16 xl:gap-24 items-center pt-2 sm:pt-4 pb-4 sm:pb-6">

        <!-- LEFT: TEXT -->
        <div class="space-y-6 sm:space-y-8">

            <div data-hero-badge class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-300/80 dark:border-slate-800 bg-slate-200/60 dark:bg-slate-900/80 shadow-sm backdrop-blur-sm">
                <span class="w-2 h-2 bg-slate-800 dark:bg-cyan-400 rounded-full animate-pulse"></span>
                <span class="text-slate-900 dark:text-slate-200 font-mono text-xs font-semibold tracking-[0.25em] uppercase">Software Engineer</span>
            </div>

            <h1 data-hero-title class="hero-title text-slate-900 dark:text-white">
                Hi, I'm
                <span class="relative inline-block">
                    <span class="text-shimmer">Krish</span>
                </span>
            </h1>

            <p data-hero-sub class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-lg leading-relaxed">
                I build scalable systems using
                <span id="stack-typing" class="text-cyan-500 dark:text-cyan-400 font-semibold font-mono"></span>
                <span class="inline-block w-[2px] h-5 bg-cyan-400 ml-0.5 align-middle animate-blink"></span>
            </p>

            <div data-hero-btns class="flex flex-wrap gap-3 sm:gap-4 pt-2">
                <a href="#projects" class="hero-btn-primary group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        View Projects
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </span>
                </a>
                <a href="https://gitlab.com/krishtbhojwani" target="_blank" class="hero-btn-ghost group">
                    <svg class="w-4 h-4 group-hover:text-cyan-400 transition" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 01-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 014.82 2a.43.43 0 01.58 0 .42.42 0 01.11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0118.6 2a.43.43 0 01.58 0 .42.42 0 01.11.18l2.44 7.51L23 13.45a.84.84 0 01-.35.94z"/>
                    </svg>
                    GitLab
                </a>
                <a href="#contact" class="hero-btn-ghost group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:text-cyan-400 transition" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    Contact
                </a>
                @if ($resumeUrl)
                    <a href="{{ $resumeUrl }}" target="_blank" class="hero-btn-ghost group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Resume
                    </a>
                @endif
            </div>

        </div>


        <!-- RIGHT: CODE CARD + FLOATING BADGES -->
        <div data-hero-card class="relative hidden md:flex items-center justify-center">

            <!-- Floating badges -->
            <div class="badge-float badge-float-1">
                <i class="devicon-laravel-plain text-red-500"></i>
                <span>Laravel</span>
            </div>
            <div class="badge-float badge-float-2">
                <i class="devicon-react-original text-cyan-400"></i>
                <span>React</span>
            </div>
            <div class="badge-float badge-float-3">
                <i class="devicon-mysql-plain text-blue-400"></i>
                <span>MySQL</span>
            </div>
            <div class="badge-float badge-float-4">
                <i class="devicon-nodejs-plain text-green-400"></i>
                <span>Node.js</span>
            </div>

            <!-- Code card with tilt -->
            <div
                x-data="{ tiltX: 0, tiltY: 0 }"
                @mousemove="tiltX = ($event.offsetY - $el.clientHeight/2) / 25; tiltY = ($el.clientWidth/2 - $event.offsetX) / 25"
                @mouseleave="tiltX = 0; tiltY = 0"
                :style="`transform: perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg)`"
                class="code-card transition-transform duration-200 ease-out"
            >
                <!-- Glow behind card -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-cyan-400/20 to-purple-500/20 blur-2xl -z-10 scale-110"></div>

                <div class="relative bg-[#0d1117] border border-white/10 rounded-2xl p-7 shadow-2xl w-[380px]">

                    <!-- Window chrome -->
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="ml-3 text-xs text-slate-600 font-mono">developer.js</span>
                    </div>

                    <!-- Syntax highlighted code -->
                    <pre class="text-sm font-mono leading-relaxed"><code
><span class="text-purple-400">const</span> <span class="text-cyan-300">developer</span> <span class="text-white">=</span> <span class="text-white">{</span>
  <span class="text-blue-300">name</span><span class="text-white">:</span>  <span class="text-green-300">"Krish Bhojwani"</span><span class="text-white">,</span>
  <span class="text-blue-300">role</span><span class="text-white">:</span>  <span class="text-green-300">"Software Engineer"</span><span class="text-white">,</span>
  <span class="text-blue-300">stack</span><span class="text-white">: [</span>
    <span class="text-green-300">"Laravel"</span><span class="text-white">,</span>
    <span class="text-green-300">"React"</span><span class="text-white">,</span>
    <span class="text-green-300">"Next.js"</span><span class="text-white">,</span>
    <span class="text-green-300">"MySQL"</span>
  <span class="text-white">],</span>
  <span class="text-blue-300">available</span><span class="text-white">:</span> <span class="text-orange-400">true</span>
<span class="text-white">}</span></code></pre>

                </div>
            </div>

        </div>

    </div>


    <!-- SCROLL INDICATOR -->
    <div class="absolute bottom-3 sm:bottom-5 left-1/2 -translate-x-1/2 hidden sm:flex flex-col items-center gap-2 text-slate-400 dark:text-slate-600">
        <span class="text-xs font-mono tracking-widest uppercase">Scroll</span>
        <div class="w-px h-12 bg-gradient-to-b from-slate-400 dark:from-slate-600 to-transparent scroll-line"></div>
    </div>


    <!-- TYPING SCRIPT -->
    <script>
        (() => {
            const stack = ['Laravel', 'Next.js', 'React', 'Livewire', 'System Design', 'Clean Arch']
            const el = document.getElementById('stack-typing')
            if (!el) return
            let wi = 0, ci = 0, deleting = false
            function type() {
                const word = stack[wi]
                el.textContent = deleting ? word.slice(0, ci--) : word.slice(0, ci++)
                if (!deleting && ci === word.length + 1) { deleting = true; setTimeout(type, 1400); return }
                if (deleting && ci === 0) { deleting = false; wi = (wi + 1) % stack.length }
                setTimeout(type, deleting ? 45 : 85)
            }
            type()
        })()
    </script>

</div>

<div>
    <section class="relative min-h-screen flex items-center overflow-hidden">

        <!-- BACKGROUND -->
        <div class="absolute inset-0 -z-10 overflow-hidden">

            <div class="absolute inset-0 opacity-20">
                <div class="grid-pattern"></div>
            </div>

            <div
                class="absolute w-[800px] h-[800px] bg-cyan-400/30 blur-[180px] rounded-full top-[-250px] left-[-250px] animate-blob">
            </div>
            <div
                class="absolute w-[700px] h-[700px] bg-blue-400/30 blur-[180px] rounded-full bottom-[-200px] right-[-200px] animate-blob animation-delay-2">
            </div>

            <div
                class="absolute w-[600px] h-[600px] bg-purple-400/20 blur-[180px] rounded-full top-[40%] left-[60%] animate-blob animation-delay-4">
            </div>

        </div>


        <div class="max-w-7xl mx-auto px-8 grid md:grid-cols-2 gap-24 items-center">

            <!-- LEFT SIDE -->
            <div class="space-y-10">

                <p class="text-cyan-500 dark:text-cyan-400 font-mono tracking-[0.35em] text-sm animate-fade-in">
                    SOFTWARE ENGINEER
                </p>


                <h1 class="hero-title text-slate-900 dark:text-white">
                    Hi, I'm
                    <span
                        class="bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent animate-gradient">
                        Krish
                    </span>
                </h1>


                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-xl leading-relaxed animate-fade-in-delay">

                    I build scalable systems using
                    <span id="stack-typing" class="text-cyan-500 dark:text-cyan-400 font-semibold"></span>

                </p>


                <!-- BUTTONS -->
                <div class="flex gap-5 pt-6 animate-fade-in-delay-2">

                    <a href="#projects" class="btn-primary text-lg px-8 py-4 hover:scale-105 transition">
                        View Projects
                    </a>

                    <a href="https://gitlab.com/krishtbhojwani" target="_blank"
                        class="btn-ghost text-lg px-8 py-4 hover:scale-105 transition">
                        GitLab
                    </a>

                </div>

            </div>



            <!-- RIGHT CODE CARD -->
            <div x-data="{ tiltX: 0, tiltY: 0 }"
                @mousemove="tiltX = ($event.offsetY - $el.clientHeight/2) / 20; tiltY = ($el.clientWidth/2 - $event.offsetX) / 20"
                @mouseleave="tiltX = 0; tiltY = 0" :style="`transform: rotateX(${tiltX}deg) rotateY(${tiltY}deg)`"
                class="relative perspective-[1000px]">

                <div class="card card-hover p-7 hero-glow transition-transform duration-300">

                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>

                    <pre class="text-sm text-slate-700 dark:text-zinc-300 font-mono leading-relaxed"><code>const developer = {
      name: "Krish",
      role: "Software Engineer",

      stack: [
        "Laravel",
        "React",
        "Next.js",
        "MySQL"
      ]
    }<span class="cursor"></span></code></pre>

                </div>

            </div>

        </div>

    </section>


    <!-- TYPING SCRIPT -->
    <script type="module">
        document.addEventListener("DOMContentLoaded", () => {

            const stack = [
                "Laravel",
                "Next.js",
                "React",
                "Automation Testing",
                "System Design",
                "Clean Architecture"
            ]

            const element = document.getElementById("stack-typing")

            let wordIndex = 0
            let charIndex = 0
            let deleting = false

            function type() {

                const word = stack[wordIndex]

                if (!deleting) {
                    element.textContent = word.slice(0, charIndex++)
                } else {
                    element.textContent = word.slice(0, charIndex--)
                }

                if (charIndex === word.length + 1) {
                    deleting = true
                    setTimeout(type, 1200)
                    return
                }

                if (charIndex === 0) {
                    deleting = false
                    wordIndex = (wordIndex + 1) % stack.length
                }

                setTimeout(type, deleting ? 40 : 80)
            }

            type()

        })
    </script>
</div>

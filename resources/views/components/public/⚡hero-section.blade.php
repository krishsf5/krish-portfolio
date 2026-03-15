<?php

use function Livewire\Volt\{state};

state([]);

?>

<section class="relative min-h-screen flex items-center overflow-hidden">

    <div class="absolute inset-0 -z-10">

        <div class="absolute w-[700px] h-[700px] bg-cyan-400/20 blur-[140px] rounded-full top-[-200px] left-[-200px]">
        </div>

        <div
            class="absolute w-[600px] h-[600px] bg-blue-400/20 blur-[140px] rounded-full bottom-[-200px] right-[-200px]">
        </div>

    </div>

    <div class="max-w-7xl mx-auto px-8 grid md:grid-cols-2 gap-20 items-center">

        <div class="space-y-6">

            <p class="text-cyan-500 dark:text-cyan-400 font-mono text-sm tracking-widest">
                SOFTWARE ENGINEER
            </p>

            <h1 class="hero-title text-slate-900 dark:text-white">
                Hi, I'm
                <span class="text-cyan-600 dark:text-cyan-400">
                    Krish
                </span>
            </h1>

            <p class="text-lg text-slate-600 dark:text-slate-400 max-w-lg">
                I design and build scalable web applications,
                developer tools, and intelligent systems using
                modern technologies.
            </p>

            <div class="flex gap-4 pt-6">

                <a href="#projects" class="btn-primary">
                    View Projects
                </a>

                <a href="https://github.com" target="_blank" class="btn-ghost">
                    GitHub
                </a>

            </div>

        </div>

        <div class="relative">

            <div class="card card-hover p-6 hero-glow">

                <div class="flex items-center gap-2 mb-4">

                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>

                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>

                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>

                </div>

                <pre class="text-sm text-slate-700 dark:text-zinc-300 font-mono leading-relaxed"><code>
const developer = {
  name: "Krish",
  role: "Software Engineer",

  stack: [
    "Laravel",
    "React",
    "Next.js",
    "MySQL"
  ]
}
</code></pre>

            </div>

        </div>

    </div>

</section>

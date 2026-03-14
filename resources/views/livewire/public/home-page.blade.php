<div class="overflow-hidden">

    <!-- HERO -->

    <section class="pt-32 pb-28 reveal">

        <div class="max-w-7xl mx-auto px-8">

            <p class="text-xs tracking-widest uppercase text-cyan-600 dark:text-cyan-400 mb-6">
                Software Engineer Portfolio
            </p>

            <h1 class="text-5xl md:text-7xl font-bold leading-tight text-slate-900 dark:text-white">

                Krish Bhojwani

                <br>

                <span class="text-cyan-600 dark:text-cyan-400">
                    Software Engineer
                </span>

            </h1>

            <p class="mt-8 max-w-xl text-lg text-slate-500 dark:text-slate-400">

                I build scalable backend systems, automation tools, and intelligent web applications using modern web
                technologies.

            </p>

            <div class="mt-10 flex gap-4">

                <a href="#projects" class="px-6 py-3 rounded-lg bg-cyan-600 text-white hover:bg-cyan-500 transition">

                    View Projects </a>

                <a href="https://github.com" target="_blank"
                    class="px-6 py-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:border-cyan-500 transition">

                    GitHub </a>

            </div>

        </div>

    </section>

    <!-- FEATURED PROJECT -->

    <section class="py-24 bg-slate-100 dark:bg-[#0c1120]  reveal">

        <div class="max-w-7xl mx-auto px-8">

            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-16">
                Featured Project
            </h2>

            <div class="grid md:grid-cols-2 gap-16 items-center">

                <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800">

                    <div
                        class="aspect-video bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                        Project Preview
                    </div>

                </div>

                <div>

                    <h3 class="text-2xl font-semibold text-slate-900 dark:text-white mb-4">
                        Blog Management System
                    </h3>

                    <p class="text-slate-500 dark:text-slate-400 mb-6">

                        AI-moderated blogging platform built with Laravel MVC architecture and Gemini AI content
                        moderation.

                    </p>

                    <div class="flex gap-4">

                        <a class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-500 transition">
                            Live Demo
                        </a>

                        <a
                            class="px-4 py-2 border rounded-lg border-slate-300 dark:border-slate-700 hover:border-cyan-500 transition">
                            GitHub
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- PROJECTS -->

    <section id="projects" class="py-28  reveal">

        <div class="max-w-7xl mx-auto px-8">

            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-16">
                Projects
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">

                @foreach ($projects as $project)
                    <a href="{{ route('project.show', $project->slug) }}">
                        <div
                            class="group rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0c1120] overflow-hidden transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                            <div class="aspect-video bg-slate-200 dark:bg-slate-800"></div>

                            <div class="p-6">

                                <h3
                                    class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-cyan-500 transition">
                                    {{ $project->title }}
                                </h3>

                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 mb-4">
                                    {{ $project->description }}
                                </p>

                                <div class="flex flex-wrap gap-2 mb-4">

                                    @foreach ($project->tags ?? [] as $tag)
                                        <span
                                            class="text-xs px-2 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                            {{ $tag }}
                                        </span>
                                    @endforeach

                                </div>

                                <div class="flex gap-3">

                                    @if ($project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank"
                                            class="text-sm px-3 py-1 rounded bg-cyan-600 text-white hover:bg-cyan-500 transition">

                                            Live </a>
                                    @endif

                                    @if ($project->repo_url)
                                        <a href="{{ $project->repo_url }}" target="_blank"
                                            class="text-sm px-3 py-1 rounded border border-slate-300 dark:border-slate-700 hover:border-cyan-500 transition">

                                            GitHub </a>
                                    @endif

                                </div>

                            </div>

                        </div>
                    </a>
                @endforeach

            </div>

        </div>

    </section>

    <!-- SKILLS -->
    <section id="skills" class="py-28 bg-slate-100 dark:bg-[#0c1120]">

        <div class="max-w-7xl mx-auto px-8">

            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-16">
                Tech Stack
            </h2>

            <div class="grid md:grid-cols-4 gap-8" id="tech-board">


                <!-- FRONTEND -->

                <div class="tech-column">

                    <h3 class="text-cyan-500 mb-4 font-semibold">
                        Frontend
                    </h3>

                    <div class="tech-list">

                        @foreach ($skills->where('category', 'Frontend') as $skill)
                            <div class="tech-card">
                                {{ $skill->name }}
                            </div>
                        @endforeach

                    </div>

                </div>


                <!-- BACKEND -->

                <div class="tech-column">

                    <h3 class="text-cyan-500 mb-4 font-semibold">
                        Backend
                    </h3>

                    <div class="tech-list">

                        @foreach ($skills->where('category', 'Backend') as $skill)
                            <div class="tech-card">
                                {{ $skill->name }}
                            </div>
                        @endforeach

                    </div>

                </div>


                <!-- DATABASE -->

                <div class="tech-column">

                    <h3 class="text-cyan-500 mb-4 font-semibold">
                        Database
                    </h3>

                    <div class="tech-list">

                        @foreach ($skills->where('category', 'Database') as $skill)
                            <div class="tech-card">
                                {{ $skill->name }}
                            </div>
                        @endforeach

                    </div>

                </div>


                <!-- TOOLS -->

                <div class="tech-column">

                    <h3 class="text-cyan-500 mb-4 font-semibold">
                        Tools
                    </h3>

                    <div class="tech-list">

                        @foreach ($skills->where('category', 'Tools') as $skill)
                            <div class="tech-card">
                                {{ $skill->name }}
                            </div>
                        @endforeach

                    </div>

                </div>


            </div>

        </div>

    </section>


    <!-- ABOUT -->

    <section id="about" class="py-28 reveal">

        <div class="max-w-4xl mx-auto px-8 text-center">

            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">
                About Me
            </h2>

            <p class="text-lg text-slate-500 dark:text-slate-400 leading-relaxed">

                Computer Engineering student focused on backend systems, automation frameworks, and building scalable
                applications.

            </p>

        </div>

    </section>

</div>

<section id="about" class="relative py-10 overflow-hidden">

    <!-- background glow -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute w-[600px] h-[600px] bg-cyan-400/20 blur-[160px] rounded-full top-[-200px] right-[-200px]">
        </div>
        <div
            class="absolute w-[500px] h-[500px] bg-purple-500/20 blur-[160px] rounded-full bottom-[-200px] left-[-200px]">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div class="relative flex justify-center">

                <div class="relative group">

                    <!-- glow -->
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-cyan-400 to-blue-500 blur-2xl opacity-30 group-hover:opacity-50 transition"></div>

                    <!-- CARD -->
                    <div class="relative bg-[#0c1120] border border-white/10 rounded-3xl p-8 backdrop-blur w-[420px]">

                        <!-- IMAGE -->
                        <img
                            src="/storage/krish.jpeg"
                            alt="avatar"
                            class="w-[360px] h-[360px] object-cover rounded-2xl mx-auto"
                        />

                        <!-- STATUS -->
                        <div class="flex justify-center mt-6">
                            <span class="flex items-center gap-2 text-sm px-5 py-2 rounded-full bg-green-500/10 text-green-400 border border-green-500/20">

                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>

                                Available for work

                            </span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- TEXT SIDE -->
            <div>

                <p class="text-cyan-400 font-mono mb-3">
                    About Me
                </p>

                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Building systems,
                    <span class="text-cyan-400">
                        not just websites
                    </span>
                </h2>

                <p class="text-gray-400 leading-relaxed mb-6">
                    I'm Krish, a computer engineering student focused on backend
                    systems and full-stack development. I enjoy building tools
                    that solve real problems — dashboards, CMS systems,
                    automation tools and developer-focused software.
                </p>

                <p class="text-gray-400 leading-relaxed mb-10">
                    My main stack revolves around Laravel, Livewire, Tailwind
                    and modern JavaScript. I care about clean architecture,
                    performance and good UI/UX.
                </p>

                <!-- STATS -->
                <div class="grid grid-cols-3 gap-6 mb-10">

                    {{-- <div
                        class="text-center p-5 rounded-xl border border-white/10 bg-[#0c1120] hover:border-cyan-400/40 transition">
                        <p class="text-3xl font-bold text-cyan-400">3+</p>
                        <p class="text-sm text-gray-400 mt-1">Years Coding</p>
                    </div> --}}

                    <div
                        class="text-center p-5 rounded-xl border border-white/10 bg-[#0c1120] hover:border-cyan-400/40 transition">
                        <p class="text-3xl font-bold text-cyan-400">15+</p>
                        <p class="text-sm text-gray-400 mt-1">Projects Built</p>
                    </div>

                    <div
                        class="text-center p-5 rounded-xl border border-white/10 bg-[#0c1120] hover:border-cyan-400/40 transition">
                        <p class="text-3xl font-bold text-cyan-400">5+</p>
                        <p class="text-sm text-gray-400 mt-1">Technologies</p>
                    </div>

                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex flex-wrap gap-4">

                    <a href="/storage/resume.pdf"
                        class="px-6 py-3 rounded-lg bg-cyan-400 text-black font-medium hover:bg-cyan-300 transition">
                        Download Resume
                    </a>

                    <a href="#projects"
                        class="px-6 py-3 rounded-lg border border-white/20 hover:border-cyan-400 hover:text-cyan-400 transition">
                        View Projects
                    </a>

                </div>

                <!-- SOCIALS -->
                <div class="flex gap-5 mt-10 text-gray-400">

                    <a href="https://gitlab.com/krishtbhojwani" target="_blank" class="hover:text-cyan-400 transition">
                        GitLab
                    </a>

                    <a href="https://linkedin.com/in/krish-bhojwani" target="_blank" class="hover:text-cyan-400 transition">
                        LinkedIn
                    </a>

                    <p class="transition text-black font-bold">
                        Email - krishtbhojwani@gmail.com
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

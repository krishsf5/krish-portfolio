<section id="contact" class="relative py-12 sm:py-16 lg:py-20 overflow-hidden">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute left-[-160px] top-20 w-[520px] h-[520px] rounded-full bg-cyan-400/10 blur-[150px]"></div>
        <div class="absolute right-[-120px] bottom-[-120px] w-[420px] h-[420px] rounded-full bg-blue-500/10 blur-[140px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-10">
        <div class="flex items-center gap-4 mb-6">
            <span class="text-[11px] font-mono tracking-[0.25em] uppercase text-cyan-400">04 - Contact</span>
            <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/30 to-transparent"></div>
        </div>

        <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-12 lg:gap-20 items-start">
            <div class="space-y-6">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Let&apos;s build something useful.
                </h2>
                <p class="text-base sm:text-lg leading-relaxed text-slate-600 dark:text-slate-400 max-w-xl">
                    Have a project, role, collaboration, or product idea in mind? Send the short version and I&apos;ll get back to you.
                </p>

                <!-- DIRECT CONTACT & SOCIAL LINKS -->
                <div class="pt-2 space-y-3.5">
                    <!-- Email -->
                    <a href="mailto:{{ $about?->email ?? 'krishtbhojwani@gmail.com' }}"
                        class="group flex items-center gap-3.5 text-slate-600 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                        <div class="w-10 h-10 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white/80 dark:bg-[#0c1120] flex items-center justify-center text-cyan-500 dark:text-cyan-400 shadow-sm group-hover:border-cyan-400/50 group-hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[11px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-500">Email</div>
                            <div class="font-medium text-sm sm:text-base text-slate-800 dark:text-slate-200 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                {{ $about?->email ?? 'krishtbhojwani@gmail.com' }}
                            </div>
                        </div>
                    </a>

                    <!-- GitLab -->
                    <a href="{{ $about?->github_url ?? 'https://gitlab.com/krishtbhojwani' }}" target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-3.5 text-slate-600 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                        <div class="w-10 h-10 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white/80 dark:bg-[#0c1120] flex items-center justify-center text-cyan-500 dark:text-cyan-400 shadow-sm group-hover:border-cyan-400/50 group-hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 01-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 014.82 2a.43.43 0 01.58 0 .42.42 0 01.11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0118.6 2a.43.43 0 01.58 0 .42.42 0 01.11.18l2.44 7.51L23 13.45a.84.84 0 01-.35.94z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[11px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-500">GitLab</div>
                            <div class="font-medium text-sm sm:text-base text-slate-800 dark:text-slate-200 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                gitlab.com/krishtbhojwani
                            </div>
                        </div>
                    </a>

                    <!-- LinkedIn -->
                    <a href="{{ $about?->linkedin_url ?? 'https://linkedin.com/in/krish-bhojwani' }}" target="_blank" rel="noopener noreferrer"
                        class="group flex items-center gap-3.5 text-slate-600 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                        <div class="w-10 h-10 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white/80 dark:bg-[#0c1120] flex items-center justify-center text-cyan-500 dark:text-cyan-400 shadow-sm group-hover:border-cyan-400/50 group-hover:shadow-[0_0_15px_rgba(34,211,238,0.2)] transition-all shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[11px] font-mono uppercase tracking-wider text-slate-400 dark:text-slate-500">LinkedIn</div>
                            <div class="font-medium text-sm sm:text-base text-slate-800 dark:text-slate-200 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                linkedin.com/in/krish-bhojwani
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <form wire:submit="submit" class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white/95 dark:bg-[#0c1120]/90 p-5 sm:p-6 md:p-8 shadow-2xl shadow-indigo-500/10 dark:shadow-black/20 space-y-5">
                @if ($successMessage)
                    <div class="rounded-lg border border-cyan-400/25 bg-cyan-400/10 px-4 py-3 text-sm text-cyan-700 dark:text-cyan-300">
                        {{ $successMessage }}
                    </div>
                @endif

                <div class="hidden">
                    <label for="contact-website">Website</label>
                    <input id="contact-website" wire:model="website" type="text" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="contact-name" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Name</label>
                        <input id="contact-name" wire:model="name" type="text" autocomplete="name"
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#080a14] text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition">
                        @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact-email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Email</label>
                        <input id="contact-email" wire:model="email" type="email" autocomplete="email"
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#080a14] text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition">
                        @error('email') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="contact-message" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Message</label>
                    <textarea id="contact-message" wire:model="message" rows="6"
                        class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-[#080a14] text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition resize-y"
                        placeholder="Tell me what you are building, hiring for, or exploring."></textarea>
                    @error('message') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex">
                    <button type="submit" class="hero-btn-primary w-full sm:w-auto" wire:loading.attr="disabled">
                        <span wire:loading.remove>Send Message</span>
                        <span wire:loading>Sending...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

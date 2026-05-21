<section id="contact" class="relative py-28 overflow-hidden">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute left-[-160px] top-20 w-[520px] h-[520px] rounded-full bg-cyan-400/10 blur-[150px]"></div>
        <div class="absolute right-[-120px] bottom-[-120px] w-[420px] h-[420px] rounded-full bg-blue-500/10 blur-[140px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="flex items-center gap-4 mb-8">
            <span class="text-[11px] font-mono tracking-[0.25em] uppercase text-cyan-400">04 - Contact</span>
            <div class="flex-1 h-px bg-gradient-to-r from-cyan-400/30 to-transparent"></div>
        </div>

        <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-12 lg:gap-20 items-start">
            <div class="space-y-6">
                <h2 class="text-4xl lg:text-5xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Let&apos;s build something useful.
                </h2>
                <p class="text-lg leading-relaxed text-slate-600 dark:text-slate-400 max-w-xl">
                    Have a project, role, collaboration, or product idea in mind? Send the short version and I&apos;ll get back to you.
                </p>

                <div class="grid sm:grid-cols-2 gap-4 pt-4">
                    <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/40 p-5">
                        <p class="text-xs font-mono uppercase tracking-widest text-slate-400">Response</p>
                        <p class="mt-2 text-slate-700 dark:text-slate-300">Usually within a day</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/40 p-5">
                        <p class="text-xs font-mono uppercase tracking-widest text-slate-400">Best for</p>
                        <p class="mt-2 text-slate-700 dark:text-slate-300">Backend, full-stack, CMS</p>
                    </div>
                </div>
            </div>

            <form wire:submit="submit" class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-[#0c1120]/90 p-6 md:p-8 shadow-xl shadow-slate-900/5 dark:shadow-black/20 space-y-5">
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
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#080a14] text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:border-cyan-400 focus:outline-none transition">
                        @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact-email" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Email</label>
                        <input id="contact-email" wire:model="email" type="email" autocomplete="email"
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#080a14] text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:border-cyan-400 focus:outline-none transition">
                        @error('email') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="contact-message" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Message</label>
                    <textarea id="contact-message" wire:model="message" rows="6"
                        class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#080a14] text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:border-cyan-400 focus:outline-none transition resize-y"
                        placeholder="Tell me what you are building, hiring for, or exploring."></textarea>
                    @error('message') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="hero-btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>Send Message</span>
                        <span wire:loading>Sending...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section id="contact" class="relative py-20 sm:py-24 lg:py-28 overflow-hidden">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute left-[-160px] top-20 w-[520px] h-[520px] rounded-full bg-cyan-400/10 blur-[150px]"></div>
        <div class="absolute right-[-120px] bottom-[-120px] w-[420px] h-[420px] rounded-full bg-blue-500/10 blur-[140px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-10">
        <div class="flex items-center gap-4 mb-8">
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
            </div>

            <form wire:submit="submit" class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white/95 dark:bg-[#0c1120]/90 p-6 md:p-8 shadow-2xl shadow-indigo-500/10 dark:shadow-black/20 space-y-5">
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
                    <button type="submit" class="hero-btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>Send Message</span>
                        <span wire:loading>Sending...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

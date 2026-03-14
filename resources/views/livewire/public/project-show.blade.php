<div class="py-24">

    <div class="max-w-6xl mx-auto px-8">

        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-6">
            {{ $project->title }}
        </h1>

        <p class="text-lg text-slate-500 dark:text-slate-400 max-w-2xl mb-12">
            {{ $project->description }}
        </p>

        <!-- HERO IMAGE -->

        <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 mb-16">

            <img src="/{{ $project->thumbnail }}" class="w-full" />

        </div>

        <!-- TECH STACK -->

        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white mb-6">
            Tech Stack
        </h2>

        <div class="flex flex-wrap gap-3 mb-16">

            @foreach ($project->tags ?? [] as $tag)
                <span
                    class="px-3 py-1 text-sm rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                    {{ $tag }}
                </span>
            @endforeach

        </div>

        <!-- PROJECT LINKS -->

        <div class="flex gap-4 mb-20">

            @if ($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank"
                    class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-500 transition">

                    Live Demo </a>
            @endif

            @if ($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank"
                    class="px-6 py-2 border rounded-lg border-slate-300 dark:border-slate-700 hover:border-cyan-500 transition">

                    GitHub </a>
            @endif

        </div>

        <!-- SCREENSHOT GALLERY -->

        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white mb-10">
            Screenshots
        </h2>

        <div class="grid md:grid-cols-2 gap-8 mb-20">

            <div class="rounded-lg overflow-hidden border border-slate-200 dark:border-slate-800">

                <div
                    class="aspect-video bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                    Screenshot
                </div>

            </div>

            <div class="rounded-lg overflow-hidden border border-slate-200 dark:border-slate-800">

                <div
                    class="aspect-video bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                    Screenshot
                </div>

            </div>

        </div>

        <!-- ARCHITECTURE -->

        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white mb-6">
            Architecture
        </h2>

        <p class="text-slate-500 dark:text-slate-400 leading-relaxed max-w-3xl">

            Explain how the system works here. Describe backend architecture,
            APIs, database design, and technical challenges solved while building the project.

        </p>

    </div>

</div>

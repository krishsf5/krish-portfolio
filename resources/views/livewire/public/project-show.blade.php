<div class="py-24">

    <div class="max-w-5xl mx-auto px-8">

        <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-6">
            {{ $project->title }}
        </h1>

        <img src="/{{ $project->thumbnail }}" class="rounded-xl mb-10 w-full" />

        <p class="text-lg text-slate-500 dark:text-slate-400 mb-8">
            {{ $project->description }}
        </p>

        <div class="flex flex-wrap gap-2 mb-10">

            @foreach ($project->tags ?? [] as $tag)
                <span class="px-3 py-1 text-sm rounded bg-slate-100 dark:bg-slate-800">
                    {{ $tag }}
                </span>
            @endforeach

        </div>

        <div class="flex gap-4">

            @if ($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" class="px-6 py-2 bg-cyan-600 text-white rounded-lg">
                    Live Demo
                </a>
            @endif

            @if ($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank"
                    class="px-6 py-2 border rounded-lg border-slate-300 dark:border-slate-700">
                    GitHub
                </a>
            @endif

        </div>

    </div>

</div>

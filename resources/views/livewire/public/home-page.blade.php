<div class="max-w-7xl mx-auto px-8 py-20 space-y-32">

    {{-- HERO --}}

    <section class="space-y-6">

        <h1 class="text-5xl font-bold text-cyan-400">
            {{ $about->full_name ?? 'Krish Bhojwani' }}
        </h1>

        <p class="text-xl text-slate-400 max-w-xl">
            {{ $about->bio ?? 'Software engineer building scalable systems.' }}
        </p>

        <div class="flex gap-4">

            <a href="#projects" class="btn-primary">
                View Projects
            </a>

            @if ($about && $about->github_url)
                <a href="{{ $about->github_url }}" target="_blank" class="btn-ghost">
                    GitHub
                </a>
            @endif

        </div>

    </section>


    {{-- PROJECTS --}}

    <section id="projects">

        <h2 class="text-3xl font-semibold text-cyan-400 mb-12">
            Projects
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach ($projects as $project)
                <div class="card card-hover p-8">

                    <h3 class="text-xl font-semibold mb-3">
                        {{ $project->title }}
                    </h3>

                    <p class="text-slate-400 mb-6">
                        {{ $project->description }}
                    </p>

                    <div class="flex flex-wrap gap-2 mb-6">

                        @foreach ($project->tags ?? [] as $tag)
                            <span class="badge-live">
                                {{ $tag }}
                            </span>
                        @endforeach

                    </div>

                    <div class="flex gap-3">

                        @if ($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" class="btn-primary">
                                Live
                            </a>
                        @endif

                        @if ($project->repo_url)
                            <a href="{{ $project->repo_url }}" target="_blank" class="btn-ghost">
                                GitHub
                            </a>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

    </section>

</div>

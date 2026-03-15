<section id="projects" class="py-32 reveal">

    <div class="max-w-7xl mx-auto px-8">

        <h2 class="text-3xl font-bold mb-20 text-slate-900 dark:text-white">
            Projects
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">

            @foreach ($projects as $project)

                <div class="project-card group relative rounded-xl overflow-hidden">

                    <!-- IMAGE -->
                    @if ($project->thumbnail)
                        <img
                            src="/storage/{{ $project->thumbnail }}"
                            class="project-image"
                        />
                    @else
                        <div class="project-image flex items-center justify-center bg-slate-200 dark:bg-zinc-800 text-slate-500">
                            No Image
                        </div>
                    @endif


                    <!-- OVERLAY -->
                    <div class="project-overlay">

                        <div class="space-y-3">

                            <h3 class="text-lg font-semibold text-white">
                                {{ $project->title }}
                            </h3>

                            <p class="text-sm text-zinc-300">
                                {{ $project->description }}
                            </p>

                            <!-- TAGS -->
                            @if ($project->tags)
                                <div class="flex flex-wrap gap-2 pt-2">

                                    @foreach ($project->tags as $tag)
                                        <span class="project-tag">
                                            {{ $tag }}
                                        </span>
                                    @endforeach

                                </div>
                            @endif


                            <!-- BUTTONS -->
                            <div class="flex gap-3 pt-3">

                                @if ($project->live_url)
                                    <a
                                        href="{{ $project->live_url }}"
                                        target="_blank"
                                        class="project-btn"
                                    >
                                        Live
                                    </a>
                                @endif

                                @if ($project->repo_url)
                                    <a
                                        href="{{ $project->repo_url }}"
                                        target="_blank"
                                        class="project-btn-outline"
                                    >
                                        Code
                                    </a>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

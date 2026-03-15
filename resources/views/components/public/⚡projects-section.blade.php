<?php

use function Livewire\Volt\{state};

state(['projects']);

?>

<section id="projects" class="py-32 reveal">

    <div class="max-w-7xl mx-auto px-8">

        <h2 class="text-3xl font-bold mb-16 text-slate-900 dark:text-white">
            Projects
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach ($projects as $project)
                <div class="group relative card overflow-hidden">

                    @if ($project->thumbnail)
                        <img src="/storage/{{ $project->thumbnail }}"
                            class="w-full h-52 object-cover transition duration-500 group-hover:scale-105" />
                    @else
                        <div
                            class="w-full h-52 flex items-center justify-center bg-slate-200 dark:bg-zinc-800 text-slate-500">
                            No Image
                        </div>
                    @endif

                    <div
                        class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-4">

                        @if ($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" class="btn-primary text-xs">
                                Live
                            </a>
                        @endif

                        @if ($project->repo_url)
                            <a href="{{ $project->repo_url }}" target="_blank" class="btn-ghost text-xs">
                                Code
                            </a>
                        @endif

                    </div>

                    <div class="p-6 space-y-3">

                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ $project->title }}
                        </h3>

                        <p class="text-sm text-slate-600 dark:text-zinc-400">
                            {{ $project->description }}
                        </p>

                        @if ($project->tags)
                            <div class="flex flex-wrap gap-2 pt-2">

                                @foreach ($project->tags as $tag)
                                    <span
                                        class="px-2 py-1 text-xs bg-slate-200 dark:bg-zinc-800 rounded text-slate-700 dark:text-zinc-300">
                                        {{ $tag }}
                                    </span>
                                @endforeach

                            </div>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</section>

<?php

use function Livewire\Volt\{state};

state(['skills']);

?>

<section id="skills" class="py-32 reveal">

    <div class="max-w-7xl mx-auto px-8">

        <h2 class="text-3xl font-bold mb-16 text-slate-900 dark:text-white">
            Tech Stack
        </h2>

        <div class="grid md:grid-cols-4 gap-8" id="tech-board">

            @foreach (['Frontend', 'Backend', 'Database', 'Tools'] as $category)
                <div class="skill-panel">

                    <h3 class="skill-title">
                        {{ $category }}
                    </h3>

                    <div class="tech-list">

                        @foreach ($skills->where('category', $category) as $skill)
                            <div class="tech-card">

                                <i class="{{ $skill->icon }}"></i>

                                <span>{{ $skill->name }}</span>

                            </div>
                        @endforeach

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</section>

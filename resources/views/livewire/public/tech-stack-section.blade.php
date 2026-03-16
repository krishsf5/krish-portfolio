<section id="skills" class="py-10 reveal relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-8">

        <h2 class="text-3xl font-bold mb-20 text-slate-900 dark:text-white">
            Tech Stack
        </h2>

        <div class="grid md:grid-cols-4 gap-10 tech-board">

            @foreach (['Frontend', 'Backend', 'Database', 'Tools'] as $category)
                <div class="tech-column">

                    <h3 class="tech-title">
                        {{ $category }}
                    </h3>

                    <div class="tech-list">

                        @foreach ($skills->where('category', $category) as $skill)
                            <div class="tech-card">

                                <div class="tech-icon">
                                    <i class="{{ $skill->icon }}"></i>
                                </div>

                                <span class="tech-name">
                                    {{ $skill->name }}
                                </span>

                            </div>
                        @endforeach

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

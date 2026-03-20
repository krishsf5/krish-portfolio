<?php

namespace App\Livewire\Public;

use App\Models\Project;
use Livewire\Component;

class ProjectShow extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $project = Project::where('slug', $this->slug)
            ->where('is_visible', true)
            ->firstOrFail();

        $related = Project::where('id', '!=', $project->id)
            ->where('is_visible', true)
            ->where('status', '!=', 'hidden')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('livewire.public.project-show', [
            'project' => $project,
            'related' => $related,
        ])->layout('layouts.public', ['title' => $project->title . ' — Krish Bhojwani']);
    }
}

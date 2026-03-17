<?php

namespace App\Livewire\Public;

use App\Models\Project;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProjectShow extends Component
{
    public Project $project;

    public function mount(string $slug): void
    {
        $this->project = Project::where('slug', $slug)
            ->where('is_visible', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.project-show')
            ->layout('layouts.public', ['title' => $this->project->title]);
    }
}

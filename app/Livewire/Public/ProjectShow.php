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
        $project = \App\Services\BackendService::getProject($this->slug);

        $allProjects = \App\Services\BackendService::getProjects();
        $related = $allProjects->where('id', '!=', $project->id)
            ->shuffle()
            ->take(3);

        return view('livewire.public.project-show', [
            'project' => $project,
            'related' => $related,
        ])->layout('layouts.public', ['title' => "{$project->title} - Krish Bhojwani"]);
    }
}

<?php

namespace App\Livewire\Public;

use Livewire\Component;

class ProjectsSection extends Component
{
    public $projects;

    public function mount($projects): void
    {
        $this->projects = $projects;
    }

    public function render()
    {
        return view('livewire.public.projects-section', [
            'projects' => $this->projects,
        ]);
    }
}

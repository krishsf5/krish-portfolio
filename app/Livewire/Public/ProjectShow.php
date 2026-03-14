<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Project;

class ProjectShow extends Component
{
    public $project;

    public function mount($slug)
    {
        $this->project = Project::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.project-show')
            ->layout('components.layouts.public');
    }
}

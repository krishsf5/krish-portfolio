<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Project;
use App\Models\Skill;
use App\Models\About;

class HomePage extends Component
{
    public $projects;
    public $skills;
    public $about;

    public function mount()
    {
        $this->projects = Project::where('is_visible', true)
            ->where('status','!=','hidden')
            ->orderBy('sort_order')
            ->get();

        $this->skills = Skill::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        $this->about = About::first();
    }

    public function render()
    {
        return view('livewire.public.home-page')
            ->layout('components.layouts.public');
    }
}

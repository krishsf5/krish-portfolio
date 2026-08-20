<?php

namespace App\Livewire;

use App\Models\About;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class HomePage extends Component
{
    public $projects;

    public $skills;

    public $about;

    public $avatar;

    public function mount(): void
    {
        $this->projects = \App\Services\BackendService::getProjects();
        $this->skills = \App\Services\BackendService::getSkills();

        $aboutData = \App\Services\BackendService::getAbout();
        $this->about = $aboutData?->about ?? null;
        $this->avatar = $aboutData?->avatar_url ?? null;
    }

    public function render()
    {
        return view('pages.home-page')
            ->layout('layouts.public');
    }
}

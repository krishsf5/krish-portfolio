<?php

namespace App\Livewire;

use App\Services\BackendService;
use Livewire\Component;

class HomePage extends Component
{
    public $projects;

    public $experiences;

    public $skills;

    public $about;

    public $avatar;

    public function mount(): void
    {
        $this->projects = BackendService::getProjects();
        $this->experiences = BackendService::getExperiences();
        $this->skills = BackendService::getSkills();

        $aboutData = BackendService::getAbout();
        $this->about = $aboutData?->about ?? null;
        $this->avatar = $aboutData?->avatar_url ?? null;
    }

    public function render()
    {
        return view('pages.home-page')
            ->layout('layouts.public');
    }
}

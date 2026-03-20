<?php

namespace App\Livewire;

use App\Models\About;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class HomePage extends Component
{
    public $projects;

    public $skills;

    public $about;

    public function mount(): void
    {
        $this->projects = Cache::remember('public.projects', 300, fn () => Project::where('is_visible', true)
            ->where('status', 'live')
            ->orderBy('sort_order')
            ->get()
        );

        $this->skills = Cache::remember('public.skills', 300, fn () => Skill::where('is_visible', true)
            ->orderBy('sort_order')
            ->get()
        );

        $this->about = Cache::remember('public.about', 300, fn () => About::first()
        );
    }

    public function render()
    {
        return view('pages.home-page')
            ->layout('layouts.public');
    }
}

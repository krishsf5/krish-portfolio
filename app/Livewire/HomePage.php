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

        $this->avatar = Cache::remember('public.avatar', 300, function () {
            $user = User::where('email', 'krishtbhojwani@gmail.com')->first();

            return $user?->avatar
            ? Storage::disk('r2')->url($user->avatar)
            : null;
        });
    }

    public function render()
    {
        return view('pages.home-page')
            ->layout('layouts.public');
    }
}

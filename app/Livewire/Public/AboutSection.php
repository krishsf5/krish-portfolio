<?php

namespace App\Livewire\Public;

use App\Models\About;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AboutSection extends Component
{
    public $about;
    public int $liveProjectCount;

    public function mount(): void
    {
        $this->about = Cache::remember('public.about', 300, fn () =>
            About::first()
        );

        $this->liveProjectCount = Cache::remember('public.projects.live_count', 300, fn () =>
            Project::where('status', 'live')
                   ->where('is_visible', true)
                   ->count()
        );
    }

    public function render()
    {
        return view('livewire.public.about-section');
    }
}

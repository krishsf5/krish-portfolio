<?php

namespace App\Livewire\Public;

use App\Models\About;
use App\Models\Project;
use App\Models\Resume;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class AboutSection extends Component
{
    public $about;
    public $avatar;

    public int $liveProjectCount;

    public function mount(): void
    {
        $this->about = Cache::remember('public.about', 300, fn () => About::first()
        );

        $this->liveProjectCount = Cache::remember('public.projects.live_count', 300, fn () => Project::where('status', 'live')
            ->where('is_visible', true)
            ->count()
        );
    }

    public function render()
    {
        $about = Cache::remember('public.about', 300, fn () => About::first()
        );

        $liveProjectCount = Cache::remember('public.projects.live_count', 300, fn () => Project::where('status', 'live')
            ->where('is_visible', true)
            ->count()
        );

        return view('livewire.public.about-section', [
            'about' => $about,
            'liveProjectCount' => $liveProjectCount,
            'avatar' => $this->avatar,
            'resumeUrl' => Cache::remember('public.resume_url', 300, function () {
                $resume = Resume::where('is_active', true)->latest()->first();

                return $resume ? Storage::url($resume->path) : null;
            }),
        ]);
    }
}

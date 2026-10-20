<?php

namespace App\Livewire\Public;

use App\Services\BackendService;
use Livewire\Component;

class AboutSection extends Component
{
    public $about;

    public $avatar;

    public int $liveProjectCount;

    public function mount(): void
    {
        $aboutData = BackendService::getAbout();
        $this->about = $aboutData?->about ?? null;
        if (is_null($this->avatar) && $aboutData) {
            $this->avatar = $aboutData->avatar_url;
        }

        $projects = BackendService::getProjects();
        $this->liveProjectCount = $projects->count();
    }

    public function render()
    {
        $resumeData = BackendService::getResume();

        return view('livewire.public.about-section', [
            'about' => $this->about,
            'liveProjectCount' => $this->liveProjectCount,
            'avatar' => $this->avatar,
            'resumeUrl' => $resumeData?->resume_url ?? null,
        ]);
    }
}

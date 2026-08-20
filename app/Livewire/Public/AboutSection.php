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
        $aboutData = \App\Services\BackendService::getAbout();
        $this->about = $aboutData?->about ?? null;
        if (is_null($this->avatar) && $aboutData) {
            $this->avatar = $aboutData->avatar_url;
        }

        $projects = \App\Services\BackendService::getProjects();
        $this->liveProjectCount = $projects->count();
    }

    public function render()
    {
        $resumeData = \App\Services\BackendService::getResume();

        return view('livewire.public.about-section', [
            'about' => $this->about,
            'liveProjectCount' => $this->liveProjectCount,
            'avatar' => $this->avatar,
            'resumeUrl' => $resumeData?->resume_url ?? null,
        ]);
    }
}

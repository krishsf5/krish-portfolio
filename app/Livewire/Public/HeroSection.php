<?php

namespace App\Livewire\Public;

use App\Services\BackendService;
use Livewire\Component;

class HeroSection extends Component
{
    public function render()
    {
        $resumeData = BackendService::getResume();

        return view('livewire.public.hero-section', [
            'resumeUrl' => $resumeData?->resume_url ?? null,
        ]);
    }
}

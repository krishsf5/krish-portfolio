<?php

namespace App\Livewire\Public;

use App\Models\Resume;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class HeroSection extends Component
{
    public function render()
    {
        $resumeData = \App\Services\BackendService::getResume();

        return view('livewire.public.hero-section', [
            'resumeUrl' => $resumeData?->resume_url ?? null,
        ]);
    }
}

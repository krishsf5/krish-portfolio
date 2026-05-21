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
        return view('livewire.public.hero-section', [
            'resumeUrl' => Cache::remember('public.resume_url', 300, function () {
                $resume = Resume::where('is_active', true)->latest()->first();

                return $resume ? Storage::url($resume->path) : null;
            }),
        ]);
    }
}

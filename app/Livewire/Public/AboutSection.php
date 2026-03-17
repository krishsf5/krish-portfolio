<?php

namespace App\Livewire\Public;

use App\Models\About;
use Livewire\Component;

class AboutSection extends Component
{
    public $about;

    public function mount(): void
    {
        $this->about = About::first();
    }

    public function render()
    {
        return view('livewire.public.about-section');
    }
}

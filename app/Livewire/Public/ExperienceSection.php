<?php

namespace App\Livewire\Public;

use Livewire\Component;

class ExperienceSection extends Component
{
    public $experiences;

    public function mount($experiences): void
    {
        $this->experiences = $experiences;
    }

    public function render()
    {
        return view('livewire.public.experience-section', [
            'experiences' => $this->experiences,
        ]);
    }
}

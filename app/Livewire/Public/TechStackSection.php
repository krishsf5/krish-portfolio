<?php

namespace App\Livewire\Public;

use Livewire\Component;

class TechStackSection extends Component
{
    public $skills;

    public function mount($skills): void
    {
        $this->skills = $skills;
    }

    public function render()
    {
        return view('livewire.public.tech-stack-section');
    }
}

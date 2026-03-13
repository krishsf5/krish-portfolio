<?php

namespace App\Livewire\About;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard — About')]
class AboutManager extends Component
{
    public function render()
    {
        return view('livewire.about.about-manager')
               ->layout('components.layouts.dashboard');
    }
}

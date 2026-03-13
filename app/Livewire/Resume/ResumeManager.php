<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard — Resume')]
class ResumeManager extends Component
{
    public function render()
    {
        return view('livewire.resume.resume-manager')
               ->layout('components.layouts.dashboard');
    }
}

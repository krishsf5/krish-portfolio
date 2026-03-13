<?php

namespace App\Livewire\Skills;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard — Skills')]
class SkillManager extends Component
{
    public function render()
    {
        return view('livewire.skills.skill-manager')
               ->layout('components.layouts.dashboard');
    }
}

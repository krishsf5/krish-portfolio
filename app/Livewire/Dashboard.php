<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Project;
use App\Models\Skill;

#[Title('Dashboard — Projects')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'totalProjects'  => Project::count(),
            'liveProjects'   => Project::where('status', 'live')->where('is_visible', true)->count(),
            'wipProjects'    => Project::where('status', 'wip')->count(),
            'hiddenProjects' => Project::where('is_visible', false)->count(),
        ])->layout('components.layouts.dashboard');
    }
}

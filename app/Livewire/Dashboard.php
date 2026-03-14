<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard - Projects')]
class Dashboard extends Component
{
    public function render()
    {
        $totalProjects = Project::count();

        $liveProjects = Project::where('status', 'live')
            ->where('is_visible', true)
            ->count();

        $wipProjects = Project::where('status', 'wip')
            ->count();

        $hiddenProjects = Project::where('is_visible', false)
            ->count();

        return view('livewire.dashboard', [
            'totalProjects' => $totalProjects,
            'liveProjects' => $liveProjects,
            'wipProjects' => $wipProjects,
            'hiddenProjects' => $hiddenProjects,
        ])->layout('components.layouts.dashboard');
    }
}

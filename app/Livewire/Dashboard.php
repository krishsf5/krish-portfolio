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
        $counts = Project::selectRaw("
        COUNT(*) as total,
        SUM(status = 'live' AND is_visible = 1) as live,
        SUM(status = 'wip') as wip,
        SUM(is_visible = 0) as hidden
    ")->first();

        return view('pages.dashboard', [
            'totalProjects' => $counts->total,
            'liveProjects' => $counts->live,
            'wipProjects' => $counts->wip,
            'hiddenProjects' => $counts->hidden,
        ])->layout('layouts.dashboard');
    }
}

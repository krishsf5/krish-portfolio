<?php

namespace App\Livewire;

use App\Services\ApiClient;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $response = ApiClient::get('/admin/projects');
        $projects = $response->successful() ? collect($response->json()) : collect();

        $totalProjects  = $projects->count();
        $liveProjects   = $projects->where('status', 'live')->where('is_visible', true)->count();
        $wipProjects    = $projects->where('status', 'wip')->count();
        $hiddenProjects = $projects->filter(fn ($p) => ! ($p['is_visible'] ?? true) || ($p['status'] ?? '') === 'hidden')->count();

        return view('pages.dashboard', compact(
            'totalProjects',
            'liveProjects',
            'wipProjects',
            'hiddenProjects',
        ))->layout('layouts.dashboard');
    }
}

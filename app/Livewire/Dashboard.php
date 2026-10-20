<?php

namespace App\Livewire;

use App\Services\ApiClient;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    #[On('project-status-updated')]
    public function refreshStats(): void
    {
        // Re-renders dashboard stats
    }

    public function updateStatus(int $id, string $status): void
    {
        if (! in_array($status, ['live', 'wip', 'hidden'])) {
            return;
        }

        $response = ApiClient::put("/admin/projects/{$id}", [
            'status' => $status,
            'is_visible' => $status !== 'hidden',
        ]);

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_token_expires_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if ($response->successful()) {
            Cache::forget('public.projects');
            $this->dispatch('project-status-updated');
        }
    }

    public function toggleVisibility(int $id): void
    {
        $response = ApiClient::get('/admin/projects');
        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_token_expires_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if (! $response->successful()) {
            return;
        }

        $project = collect(json_decode($response->body()))->firstWhere('id', $id);
        if (! $project) {
            return;
        }

        $newVisible = ! ($project->is_visible ?? true);
        $putResponse = ApiClient::put("/admin/projects/{$id}", [
            'is_visible' => $newVisible,
        ]);

        if ($putResponse->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_token_expires_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if ($putResponse->successful()) {
            Cache::forget('public.projects');
            $this->dispatch('project-status-updated');
        }
    }

    public function render()
    {
        $response = ApiClient::get('/admin/projects');

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_token_expires_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return view('pages.dashboard', [
                'totalProjects' => 0,
                'liveProjects' => 0,
                'wipProjects' => 0,
                'hiddenProjects' => 0,
            ])->layout('layouts.dashboard');
        }

        $projects = $response->successful() ? collect(json_decode($response->body())) : collect();

        $totalProjects = $projects->count();
        $liveProjects = $projects->where('status', 'live')->where('is_visible', true)->count();
        $wipProjects = $projects->where('status', 'wip')->count();
        $hiddenProjects = $projects->filter(fn ($p) => ! ($p->is_visible ?? true) || ($p->status ?? '') === 'hidden')->count();

        return view('pages.dashboard', compact(
            'totalProjects',
            'liveProjects',
            'wipProjects',
            'hiddenProjects',
        ))->layout('layouts.dashboard');
    }
}

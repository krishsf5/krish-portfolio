<?php

namespace App\Livewire\Projects;

use App\Services\ApiClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectManager extends Component
{
    use WithFileUploads;

    public bool $showModal = false;

    public bool $showDelete = false;

    public ?int $editingId = null;

    public ?int $deletingId = null;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('nullable|url|max:255')]
    public string $live_url = '';

    #[Validate('nullable|url|max:255')]
    public string $repo_url = '';

    #[Validate('nullable|string|max:500')]
    public string $tags = '';

    #[Validate('required|in:live,wip,hidden')]
    public string $status = 'wip';

    #[Validate('nullable|date')]
    public string $start_date = '';

    #[Validate('nullable|date')]
    public string $end_date = '';

    #[Validate('nullable|image|max:5120')]
    public $thumbnail;

    public ?string $existingThumbnail = null;

    public array $existingMedia = [];

    #[Validate(['newMedia.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,webm,mov,ogg|max:25600'])]
    public array $newMedia = [];

    public string $error = '';

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $response = ApiClient::get('/admin/projects');
        if ($response->successful()) {
            $project = collect(json_decode($response->body()))->firstWhere('id', $id);
            if ($project) {
                $this->editingId = $id;
                $this->title = $project->title ?? '';
                $this->description = $project->description ?? '';
                $this->live_url = $project->live_url ?? '';
                $this->repo_url = $project->repo_url ?? '';
                $this->tags = is_array($project->tags ?? null) ? implode(', ', $project->tags) : ($project->tags ?? '');
                $this->status = $project->status ?? 'wip';
                $this->start_date = ! empty($project->start_date) ? Carbon::parse($project->start_date)->format('Y-m') : '';
                $this->end_date = ! empty($project->end_date) ? Carbon::parse($project->end_date)->format('Y-m') : '';
                $this->existingThumbnail = $project->thumbnail ?? null;
                $this->existingMedia = is_array($project->media ?? null) ? json_decode(json_encode($project->media), true) : [];
                $this->newMedia = [];
                $this->showModal = true;
            }
        }
    }

    public function removeExistingMedia(int $index): void
    {
        if (isset($this->existingMedia[$index])) {
            array_splice($this->existingMedia, $index, 1);
        }
    }

    public function removeNewMedia(int $index): void
    {
        if (isset($this->newMedia[$index])) {
            array_splice($this->newMedia, $index, 1);
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => trim($this->title),
            'description' => trim($this->description) ?: null,
            'live_url' => trim($this->live_url) ?: null,
            'repo_url' => trim($this->repo_url) ?: null,
            'tags' => $this->parseTags($this->tags),
            'status' => $this->status,
            'is_visible' => $this->status !== 'hidden',
            'start_date' => $this->start_date ? Carbon::parse($this->start_date.'-01')->format('Y-m-d') : null,
            'end_date' => $this->end_date ? Carbon::parse($this->end_date.'-01')->format('Y-m-d') : null,
            'existing_media' => $this->existingMedia,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail;
        }

        if (! empty($this->newMedia)) {
            $data['media_files'] = $this->newMedia;
        }

        $hasFiles = (bool) $this->thumbnail || ! empty($this->newMedia);

        if ($this->editingId) {
            $response = $hasFiles
                ? ApiClient::putMultipart("/admin/projects/{$this->editingId}", $data)
                : ApiClient::put("/admin/projects/{$this->editingId}", $data);
            $msg = 'Project updated.';
        } else {
            $response = $hasFiles
                ? ApiClient::postMultipart('/admin/projects', $data)
                : ApiClient::post('/admin/projects', $data);
            $msg = 'Project created.';
        }

        if ($response->successful()) {
            Cache::forget('public.projects');
            $this->dispatch('project-status-updated');
            $this->error = '';
            session()->flash('success', $msg);
            $this->closeModal();
        } else {
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);

                return;
            }
            $this->error = $response->json('message', 'Failed to save project.');
        }
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

        if ($response->successful()) {
            Cache::forget('public.projects');
            $this->dispatch('project-status-updated');
            $this->error = '';
        } else {
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);

                return;
            }
            $this->error = $response->json('message', 'Failed to update project status.');
        }
    }

    public function toggleVisibility(int $id): void
    {
        $response = ApiClient::get('/admin/projects');
        if (! $response->successful()) {
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);
            }

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

        if ($putResponse->successful()) {
            Cache::forget('public.projects');
            $this->dispatch('project-status-updated');
            $this->error = '';
        } else {
            if ($putResponse->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);

                return;
            }
            $this->error = $putResponse->json('message', 'Failed to update project visibility.');
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDelete = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            $response = ApiClient::delete("/admin/projects/{$this->deletingId}");
            if ($response->successful()) {
                Cache::forget('public.projects');
                $this->dispatch('project-status-updated');
                $this->error = '';
                session()->flash('success', 'Project deleted.');
            } else {
                if ($response->status() === 401) {
                    session()->forget(['api_token', 'api_user', 'api_login_at']);
                    session()->flash('error', 'Your session has expired. Please log in again.');
                    $this->redirect(route('login'), navigate: true);

                    return;
                }
                $this->error = $response->json('message', 'Failed to delete project.');
            }
        }
        $this->showDelete = false;
        $this->deletingId = null;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDelete = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = '';
        $this->live_url = '';
        $this->repo_url = '';
        $this->tags = '';
        $this->status = 'wip';
        $this->start_date = '';
        $this->end_date = '';
        $this->thumbnail = null;
        $this->existingThumbnail = null;
        $this->existingMedia = [];
        $this->newMedia = [];
        $this->error = '';
        $this->resetValidation();
    }

    private function parseTags(string $raw): array
    {
        return collect(explode(',', $raw))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }

    public function render()
    {
        $response = ApiClient::get('/admin/projects');

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user', 'api_login_at']);
            session()->flash('error', 'Your session has expired. Please log in again.');
            $this->redirect(route('login'), navigate: true);

            return view('livewire.admin.projects.project-manager', ['projects' => collect()])
                ->layout('layouts.dashboard');
        }

        $projects = $response->successful()
            ? collect(json_decode($response->body()))->map(function ($p) {
                $p->id = $p->id ?? 0;
                $p->title = $p->title ?? 'Untitled';
                $p->thumbnail = $p->thumbnail ?? null;
                $p->live_url = $p->live_url ?? null;
                $p->repo_url = $p->repo_url ?? null;
                $p->status = $p->status ?? 'wip';
                $p->is_visible = $p->is_visible ?? true;
                $p->description = $p->description ?? null;
                $p->tags = is_array($p->tags ?? null) ? $p->tags : [];
                $p->start_date = $p->start_date ?? null;
                $p->end_date = $p->end_date ?? null;

                return $p;
            })
            : collect();

        return view('livewire.admin.projects.project-manager', compact('projects'))
            ->layout('layouts.dashboard');
    }
}

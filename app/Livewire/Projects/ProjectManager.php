<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
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

    // ── NEW ──────────────────────────────────────────
    #[Validate('nullable|date')]
    public string $start_date = '';

    #[Validate('nullable|date')]
    public string $end_date = '';
    // ─────────────────────────────────────────────────

    #[Validate('nullable|image|max:2048')]
    public $thumbnail;

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $project = Project::findOrFail($id);

        $this->editingId    = $id;
        $this->title        = $project->title;
        $this->description  = $project->description ?? '';
        $this->live_url     = $project->live_url ?? '';
        $this->repo_url     = $project->repo_url ?? '';
        $this->tags         = is_array($project->tags) ? implode(', ', $project->tags) : '';
        $this->status       = $project->status;

        // ── NEW ──────────────────────────────────────────
        // type="month" input expects YYYY-MM format
        $this->start_date   = $project->start_date
            ? \Carbon\Carbon::parse($project->start_date)->format('Y-m')
            : '';

        $this->end_date     = $project->end_date
            ? \Carbon\Carbon::parse($project->end_date)->format('Y-m')
            : '';
        // ─────────────────────────────────────────────────

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title'       => trim($this->title),
            'description' => trim($this->description) ?: null,
            'live_url'    => trim($this->live_url) ?: null,
            'repo_url'    => trim($this->repo_url) ?: null,
            'tags'        => $this->parseTags($this->tags),
            'status'      => $this->status,
            'is_visible'  => $this->status !== 'hidden',

            // ── NEW ──────────────────────────────────────────
            // Store as YYYY-MM-01 so DB date column is happy
            'start_date'  => $this->start_date ? $this->start_date . '-01' : null,
            'end_date'    => $this->end_date   ? $this->end_date   . '-01' : null,
            // ─────────────────────────────────────────────────
        ];

        if ($this->thumbnail) {
            if ($this->editingId) {
                $old = Project::find($this->editingId)?->thumbnail;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['thumbnail'] = $this->thumbnail->store('projects', 'public');
        }

        if ($this->editingId) {

            Project::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Project updated successfully.');

        } else {

            $data['sort_order'] = Project::max('sort_order') + 1;
            Project::create($data);
            session()->flash('success', 'Project created successfully.');

        }

        $this->closeModal();
        Cache::forget('public.projects');
        Cache::forget('public.projects.live_count');
    }

    public function toggleVisibility(int $id): void
    {
        $project = Project::findOrFail($id);
        $project->update([
            'is_visible' => ! $project->is_visible,
        ]);

        Cache::forget('public.projects');
        Cache::forget('public.projects.live_count');
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDelete = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            $project = Project::findOrFail($this->deletingId);

            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $project->delete();
            session()->flash('success', 'Project deleted.');
        }

        $this->showDelete = false;
        $this->deletingId = null;

        Cache::forget('public.projects');
        Cache::forget('public.projects.live_count');
    }

    public function closeModal(): void
    {
        $this->showModal  = false;
        $this->showDelete = false;
        $this->resetForm();
    }

    // ── NEW — AI action stubs, wire up to API later ──
    public function improveWriting(): void  { /* TODO: call AI API, update $this->description */ }
    public function suggestContent(): void  { /* TODO */ }
    public function grammarCheck(): void    { /* TODO */ }
    public function makeShorter(): void     { /* TODO */ }
    // ─────────────────────────────────────────────────

    private function resetForm(): void
    {
        $this->thumbnail  = null;
        $this->title      = '';
        $this->description = '';
        $this->live_url   = '';
        $this->repo_url   = '';
        $this->tags       = '';
        $this->status     = 'wip';
        $this->editingId  = null;

        // ── NEW ──────────────────────────────────────────
        $this->start_date = '';
        $this->end_date   = '';
        // ─────────────────────────────────────────────────

        $this->resetValidation();
    }

    private function parseTags(string $raw): array
    {
        if (empty(trim($raw))) {
            return [];
        }

        return array_values(
            array_filter(
                array_map('trim', explode(',', $raw))
            )
        );
    }

    public function render()
    {
        return view('livewire.admin.projects.project-manager', [
            'projects' => Project::orderBy('sort_order')->orderByDesc('created_at')->get(),
        ]);
    }
}

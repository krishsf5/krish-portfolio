<?php

namespace App\Livewire\Projects;

use App\Models\Project;
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

        $this->editingId = $id;
        $this->title = $project->title;
        $this->description = $project->description ?? '';
        $this->live_url = $project->live_url ?? '';
        $this->repo_url = $project->repo_url ?? '';
        $this->tags = is_array($project->tags) ? implode(', ', $project->tags) : '';
        $this->status = $project->status;
        $this->showModal = true;
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
        ];

        if ($this->thumbnail) {
            if ($this->editingId) {
                $old = Project::find($this->editingId)?->thumbnail;
                if ($old) {
                    \Storage::disk('public')->delete($old);
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
    }

    public function toggleVisibility(int $id): void
    {
        Project::where('id', $id)->update([
            'is_visible' => \DB::raw('NOT is_visible'),
        ]);
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDelete = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            Project::findOrFail($this->deletingId)->delete();
            session()->flash('success', 'Project deleted.');
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

        $this->thumbnail = null;
        $this->title = '';
        $this->description = '';
        $this->live_url = '';
        $this->repo_url = '';
        $this->tags = '';
        $this->status = 'wip';
        $this->editingId = null;
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

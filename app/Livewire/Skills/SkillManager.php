<?php

namespace App\Livewire\Skills;

use App\Services\ApiClient;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard — Skills')]
class SkillManager extends Component
{
    public bool $showModal  = false;
    public bool $showDelete = false;

    public ?int $editingId  = null;
    public ?int $deletingId = null;

    public string $name        = '';
    public string $category    = 'Frontend';
    public int    $proficiency = 5;
    public string $icon        = '';
    public bool   $is_visible  = true;

    public string $error = '';

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $response = ApiClient::get('/admin/skills');
        if ($response->successful()) {
            $skill = collect(json_decode($response->body()))->firstWhere('id', $id);
            if ($skill) {
                $this->editingId   = $id;
                $this->name        = $skill->name ?? '';
                $this->category    = $skill->category ?? 'Frontend';
                $this->proficiency = $skill->proficiency ?? 5;
                $this->icon        = $skill->icon ?? '';
                $this->is_visible  = $skill->is_visible ?? true;
                $this->showModal   = true;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'name'        => ['required', 'string', 'max:100'],
            'category'    => ['required', 'in:Frontend,Backend,Database,Tools'],
            'proficiency' => ['required', 'integer', 'min:1', 'max:100'],
            'icon'        => ['nullable', 'string', 'max:100'],
        ]);

        $data = [
            'name'        => trim($this->name),
            'category'    => $this->category,
            'proficiency' => $this->proficiency,
            'icon'        => trim($this->icon) ?: null,
            'is_visible'  => $this->is_visible,
        ];

        if ($this->editingId) {
            $response = ApiClient::put("/admin/skills/{$this->editingId}", $data);
            $msg = 'Skill updated.';
        } else {
            $response = ApiClient::post('/admin/skills', $data);
            $msg = 'Skill created.';
        }

        if ($response->successful()) {
            Cache::forget('public.skills');
            session()->flash('success', $msg);
            $this->closeModal();
        } else {
            $this->error = $response->json('message', 'Failed to save skill.');
        }
    }

    public function toggleVisibility(int $id): void
    {
        ApiClient::patch("/admin/skills/{$id}/toggle");
        Cache::forget('public.skills');
    }

    public function moveUp(int $id): void
    {
        ApiClient::patch("/admin/skills/{$id}/move-up");
        Cache::forget('public.skills');
    }

    public function moveDown(int $id): void
    {
        ApiClient::patch("/admin/skills/{$id}/move-down");
        Cache::forget('public.skills');
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDelete = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            ApiClient::delete("/admin/skills/{$this->deletingId}");
            Cache::forget('public.skills');
            session()->flash('success', 'Skill deleted.');
        }
        $this->showDelete = false;
        $this->deletingId = null;
    }

    public function closeModal(): void
    {
        $this->showModal  = false;
        $this->showDelete = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingId   = null;
        $this->name        = '';
        $this->category    = 'Frontend';
        $this->proficiency = 5;
        $this->icon        = '';
        $this->is_visible  = true;
        $this->error       = '';
        $this->resetValidation();
    }

    public function render()
    {
        $response = ApiClient::get('/admin/skills');
        $skills   = $response->successful()
            ? collect(json_decode($response->body()))->groupBy('category')
            : collect();

        return view('livewire.admin.skills.skill-manager', compact('skills'))
            ->layout('layouts.dashboard');
    }
}

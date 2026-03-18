<?php

namespace App\Livewire\Skills;

use App\Models\Skill;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Dashboard — Skills')]
class SkillManager extends Component
{
    public bool $showModal = false;

    public bool $showDelete = false;

    public ?int $editingId = null;

    public ?int $deletingId = null;

    #[Validate('required|string|max:100')]
    public string $name = '';

    #[Validate('required|in:Frontend,Backend,Database,Tools')]
    public string $category = 'Frontend';

    #[Validate('required|integer|min:1|max:10')]
    public int $proficiency = 5;

    #[Validate('nullable|string|max:100')]
    public string $icon = '';

    public bool $is_visible = true;

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $skill = Skill::findOrFail($id);

        $this->editingId = $id;
        $this->name = $skill->name;
        $this->category = $skill->category;
        $this->proficiency = $skill->proficiency;
        $this->icon = $skill->icon ?? '';
        $this->is_visible = $skill->is_visible;

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => trim($this->name),
            'category' => $this->category,
            'proficiency' => $this->proficiency,
            'icon' => trim($this->icon) ?: null,
            'is_visible' => $this->is_visible,
        ];

        if ($this->editingId) {
            Skill::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Skill updated.');
        } else {
            $data['sort_order'] = Skill::max('sort_order') + 1;
            Skill::create($data);
            session()->flash('success', 'Skill created.');
        }

        $this->closeModal();
        Cache::forget('public.skills');
    }

    public function toggleVisibility(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $skill->update(['is_visible' => ! $skill->is_visible]);

        Cache::forget('public.skills');
    }

    public function moveUp(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $prev = Skill::where('category', $skill->category)
            ->where('sort_order', '<', $skill->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if ($prev) {
            DB::transaction(function () use ($skill, $prev) {
                [$skill->sort_order, $prev->sort_order] = [$prev->sort_order, $skill->sort_order];
                $skill->save();
                $prev->save();
            });
        }
    }

    public function moveDown(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $next = Skill::where('category', $skill->category)
            ->where('sort_order', '>', $skill->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($next) {
            DB::transaction(function () use ($skill, $next) {
                [$skill->sort_order, $next->sort_order] = [$next->sort_order, $skill->sort_order];
                $skill->save();
                $next->save();
            });
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
            Skill::findOrFail($this->deletingId)->delete();
            session()->flash('success', 'Skill deleted.');
        }

        $this->showDelete = false;
        $this->deletingId = null;

        Cache::forget('public.skills');
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
        $this->name = '';
        $this->category = 'Frontend';
        $this->proficiency = 5;
        $this->icon = '';
        $this->is_visible = true;
        $this->resetValidation();
    }

    public function render()
    {
        $skills = Skill::orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('livewire.admin.skills.skill-manager', compact('skills'))
            ->layout('layouts.dashboard');
    }
}

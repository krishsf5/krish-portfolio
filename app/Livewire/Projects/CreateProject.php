<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;

class CreateProject extends Component
{
    public $title;
    public $description;
    public $status = 'wip';
    public $tags;
    public $live_url;
    public $repo_url;

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
        ]);

        Project::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'tags' => $this->tags ? array_map('trim', explode(',', $this->tags)) : [],
            'live_url' => $this->live_url,
            'repo_url' => $this->repo_url,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Project created successfully');
    }

    public function render()
    {
        return view('livewire.admin.projects.create-project')->layout('layouts.dashboard');;
    }
}

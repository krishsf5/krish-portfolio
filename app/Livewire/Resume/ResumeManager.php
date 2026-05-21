<?php

namespace App\Livewire\Resume;

use App\Models\Resume;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Dashboard — Resume')]
class ResumeManager extends Component
{
    use WithFileUploads;

    #[Validate('required|file|mimes:pdf|max:5120')]
    public $pdf = null;

    public function upload(): void
    {
        $this->validate();

        $path = $this->pdf->store('resumes', 'public');

        // deactivate all existing
        Resume::query()->update(['is_active' => false]);

        Resume::create([
            'filename' => $this->pdf->getClientOriginalName(),
            'path' => $path,
            'size_kb' => (int) round($this->pdf->getSize() / 1024),
            'is_active' => true,
        ]);

        $this->pdf = null;
        Cache::forget('public.resume_url');
        session()->flash('success', 'Resume uploaded and set as active.');
    }

    public function activate(int $id): void
    {
        Resume::query()->update(['is_active' => false]);
        Resume::findOrFail($id)->update(['is_active' => true]);
        Cache::forget('public.resume_url');
    }

    public function delete(int $id): void
    {
        $resume = Resume::findOrFail($id);
        $wasActive = $resume->is_active;

        Storage::disk('public')->delete($resume->path);
        $resume->delete();

        if ($wasActive) {
            Resume::latest()->first()?->update(['is_active' => true]);
            Cache::forget('public.resume_url');
        }

        session()->flash('success', 'Resume deleted.');
    }

    public function render()
    {
        return view('livewire.admin.resume.resume-manager', [
            'resumes' => Resume::orderByDesc('created_at')->get(),
        ])->layout('layouts.dashboard');
    }
}

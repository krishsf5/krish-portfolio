<?php

namespace App\Livewire\Resume;

use App\Services\ApiClient;
use Illuminate\Support\Facades\Cache;
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

    public string $error = '';

    public function upload(): void
    {
        $this->validate();

        $response = ApiClient::postMultipart('/admin/resume', ['pdf' => $this->pdf]);

        if ($response->successful()) {
            Cache::forget('public.resume_data');
            $this->pdf = null;
            session()->flash('success', 'Resume uploaded and set as active.');
        } else {
            $this->error = $response->json('message', 'Failed to upload resume.');
        }
    }

    public function activate(int $id): void
    {
        $response = ApiClient::patch("/admin/resume/{$id}/activate");
        if ($response->successful()) {
            Cache::forget('public.resume_data');
        }
    }

    public function delete(int $id): void
    {
        $response = ApiClient::delete("/admin/resume/{$id}");
        if ($response->successful()) {
            Cache::forget('public.resume_data');
            session()->flash('success', 'Resume deleted.');
        }
    }

    public function render()
    {
        $response = ApiClient::get('/admin/resume');
        $resumes  = $response->successful()
            ? collect($response->json())
            : collect();

        return view('livewire.admin.resume.resume-manager', compact('resumes'))
            ->layout('layouts.dashboard');
    }
}

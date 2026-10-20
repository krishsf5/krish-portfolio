<?php

namespace App\Livewire\Resume;

use App\Services\ApiClient;
use Carbon\Carbon;
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
            $this->error = '';
            session()->flash('success', 'Resume uploaded and set as active.');
        } else {
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);

                return;
            }
            $this->error = $response->json('message', 'Failed to upload resume.');
        }
    }

    public function activate(int $id): void
    {
        $response = ApiClient::patch("/admin/resume/{$id}/activate");
        if ($response->successful()) {
            Cache::forget('public.resume_data');
            $this->error = '';
            session()->flash('success', 'Active resume updated.');
        } else {
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);

                return;
            }
            $this->error = $response->json('message', 'Failed to activate resume.');
        }
    }

    public function delete(int $id): void
    {
        $response = ApiClient::delete("/admin/resume/{$id}");
        if ($response->successful()) {
            Cache::forget('public.resume_data');
            $this->error = '';
            session()->flash('success', 'Resume deleted.');
        } else {
            if ($response->status() === 401) {
                session()->forget(['api_token', 'api_user', 'api_login_at']);
                session()->flash('error', 'Your session has expired. Please log in again.');
                $this->redirect(route('login'), navigate: true);

                return;
            }
            $this->error = $response->json('message', 'Failed to delete resume.');
        }
    }

    public function render()
    {
        $response = ApiClient::get('/admin/resume');
        $resumes = $response->successful()
            ? collect(json_decode($response->body()))->map(function ($r) {
                if (isset($r->created_at)) {
                    $r->created_at = Carbon::parse($r->created_at);
                }

                return $r;
            })
            : collect();

        return view('livewire.admin.resume.resume-manager', compact('resumes'))
            ->layout('layouts.dashboard');
    }
}

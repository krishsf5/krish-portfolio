<?php

namespace App\Livewire\Public;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use App\Services\BackendService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class ContactSection extends Component
{
    public string $name = '';

    public string $email = '';

    public string $message = '';

    public string $website = '';

    public ?string $successMessage = null;

    public function submit(): void
    {
        $this->successMessage = null;

        if (filled($this->website)) {
            $this->resetForm();
            $this->successMessage = 'Thanks, your message has been sent.';

            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        $rateLimitKey = $this->rateLimitKey($validated['email']);

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $this->addError('email', 'Too many messages sent. Please try again later.');

            return;
        }

        RateLimiter::hit($rateLimitKey, 600);

        $success = BackendService::submitInquiry([
            'name' => trim($validated['name']),
            'email' => Str::lower(trim($validated['email'])),
            'message' => trim($validated['message']),
        ]);

        if ($success) {
            $inquiry = new ContactInquiry([
                'name' => trim($validated['name']),
                'email' => Str::lower(trim($validated['email'])),
                'message' => trim($validated['message']),
            ]);

            $aboutData = BackendService::getAbout();
            $recipient = $aboutData?->about?->email ?? config('mail.admin_recipient', 'krishtbhojwani@gmail.com');

            if (filled($recipient)) {
                try {
                    Mail::to($recipient)->send(new ContactInquiryReceived($inquiry));
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send contact inquiry notification email: '.$e->getMessage());
                }
            }
        }

        $this->resetForm();
        $this->successMessage = 'Thanks, your message has been sent.';
    }

    private function resetForm(): void
    {
        $this->reset('name', 'email', 'message', 'website');
        $this->resetValidation();
    }

    private function rateLimitKey(string $email): string
    {
        return 'contact-inquiry:'.sha1(request()->ip().'|'.Str::lower(trim($email)));
    }

    private function ipHash(): ?string
    {
        $ip = request()->ip();

        return $ip ? hash('sha256', $ip.'|'.config('app.key')) : null;
    }

    public function render()
    {
        $aboutData = BackendService::getAbout();

        return view('livewire.public.contact-section', [
            'about' => $aboutData?->about ?? null,
        ]);
    }
}

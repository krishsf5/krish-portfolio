<?php

namespace App\Livewire\Public;

use App\Mail\ContactInquiryReceived;
use App\Models\About;
use App\Models\ContactInquiry;
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

        $inquiry = ContactInquiry::create([
            'name' => trim($validated['name']),
            'email' => Str::lower(trim($validated['email'])),
            'message' => trim($validated['message']),
            'status' => ContactInquiry::STATUS_UNREAD,
            'ip_hash' => $this->ipHash(),
            'user_agent' => Str::limit((string) request()->userAgent(), 500, ''),
        ]);

        $recipient = About::query()->whereNotNull('email')->value('email');

        if (filled($recipient)) {
            Mail::to($recipient)->send(new ContactInquiryReceived($inquiry));
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
        return view('livewire.public.contact-section');
    }
}

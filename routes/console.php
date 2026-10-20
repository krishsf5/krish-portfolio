<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mail:test {recipient?}', function () {
    $recipient = $this->argument('recipient') ?? config('mail.admin_recipient', 'krishtbhojwani@gmail.com');
    $mailer = config('mail.default');
    $this->info("Sending demo inquiry email to [{$recipient}] using mailer [{$mailer}]...");

    try {
        $demoInquiry = new \App\Models\ContactInquiry([
            'name' => 'Sarah Connor (Demo Client)',
            'email' => 'sarah.connor@example.com',
            'message' => "Hi Krish,\n\nI reviewed your portfolio and was really impressed with your backend projects. I would love to connect and discuss an engineering opportunity with you.\n\nBest regards,\nSarah Connor",
        ]);

        \Illuminate\Support\Facades\Mail::to($recipient)->send(new \App\Mail\ContactInquiryReceived($demoInquiry));

        $this->info("SUCCESS: Demo inquiry email was sent successfully to [{$recipient}]!");
        return 0;
    } catch (\Throwable $e) {
        $this->error("ERROR: Failed to send email: " . $e->getMessage());
        return 1;
    }
})->purpose('Send a demo inquiry email using the configured mail settings');


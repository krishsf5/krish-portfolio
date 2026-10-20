<?php

namespace Tests\Feature;

use App\Livewire\Inquiries\InquiryManager;
use App\Livewire\Public\ContactSection;
use App\Mail\ContactInquiryReceived;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class ContactInquiryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
        RateLimiter::clear($this->rateLimitKey('person@example.com'));
        RateLimiter::clear($this->rateLimitKey('ownerless@example.com'));
        RateLimiter::clear($this->rateLimitKey('throttle@example.com'));
    }

    public function test_homepage_renders_contact_section_and_nav_link(): void
    {
        Http::fake([
            '*/api/*' => Http::response([], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="contact"', false)
            ->assertSee('Contact');
    }

    public function test_contact_form_validates_required_fields(): void
    {
        Livewire::test(ContactSection::class)
            ->call('submit')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'required',
                'message' => 'required',
            ]);
    }

    public function test_successful_submission_sends_inquiry_and_owner_email(): void
    {
        Mail::fake();

        Http::fake([
            '*/api/inquiries' => Http::response(['id' => 1, 'ok' => true], 201),
            '*/api/about' => Http::response(['about' => ['email' => 'owner@example.com']], 200),
        ]);

        Livewire::test(ContactSection::class)
            ->set('name', 'Test Person')
            ->set('email', 'person@example.com')
            ->set('message', 'I would like to discuss a Laravel project with you.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Thanks, your message has been sent.');

        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/inquiries')
                && $request['email'] === 'person@example.com';
        });

        Mail::assertSent(ContactInquiryReceived::class, function (ContactInquiryReceived $mail) {
            return $mail->hasTo('owner@example.com')
                && $mail->inquiry->email === 'person@example.com';
        });
    }

    public function test_honeypot_submission_is_silently_accepted_without_saving_or_mailing(): void
    {
        Mail::fake();
        Http::fake();

        Livewire::test(ContactSection::class)
            ->set('name', 'Bot Person')
            ->set('email', 'bot@example.com')
            ->set('message', 'This submission should be ignored because the honeypot is filled.')
            ->set('website', 'https://spam.example')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Thanks, your message has been sent.');

        Http::assertNotSent(function ($request) {
            return str_contains($request->url(), '/inquiries');
        });
        Mail::assertNothingSent();
    }

    public function test_repeated_submissions_are_throttled(): void
    {
        Mail::fake();
        Http::fake([
            '*/api/inquiries' => Http::response(['id' => 1, 'ok' => true], 201),
            '*/api/about' => Http::response(['about' => ['email' => 'owner@example.com']], 200),
        ]);

        $component = Livewire::test(ContactSection::class);

        for ($i = 1; $i <= 3; $i++) {
            $component
                ->set('name', 'Throttle Person')
                ->set('email', 'throttle@example.com')
                ->set('message', "This is accepted message number {$i}.")
                ->call('submit')
                ->assertHasNoErrors();
        }

        $component
            ->set('name', 'Throttle Person')
            ->set('email', 'throttle@example.com')
            ->set('message', 'This fourth message should be blocked by throttling.')
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    public function test_guests_cannot_access_inquiry_dashboard(): void
    {
        $this->get(route('inquiries'))->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_manage_inquiry_status(): void
    {
        Http::fake([
            '*/api/admin/inquiries*' => Http::response([
                'inquiries' => [
                    [
                        'id' => 1,
                        'name' => 'Inbox Person',
                        'email' => 'inbox@example.com',
                        'message' => 'Please read this inquiry.',
                        'status' => 'unread',
                        'created_at' => '2026-09-20 00:00:00',
                        'read_at' => null,
                        'archived_at' => null,
                    ],
                ],
                'unread_count' => 1,
            ], 200),
            '*/api/admin/inquiries/1' => Http::response([
                'id' => 1,
                'name' => 'Inbox Person',
                'email' => 'inbox@example.com',
                'message' => 'Please read this inquiry.',
                'status' => 'read',
                'created_at' => '2026-09-20 00:00:00',
                'read_at' => '2026-09-20 01:00:00',
                'archived_at' => null,
            ], 200),
            '*/api/admin/inquiries/1/read' => Http::response(['ok' => true], 200),
            '*/api/admin/inquiries/1/unread' => Http::response(['ok' => true], 200),
            '*/api/admin/inquiries/1/archive' => Http::response(['ok' => true], 200),
        ]);

        $session = [
            'api_token' => 'mock-token',
            'api_login_at' => time(),
            'api_user' => ['id' => 1, 'name' => 'Krish', 'email' => 'krishtbhojwani@gmail.com'],
        ];

        $this->withSession($session)
            ->get(route('inquiries'))
            ->assertOk()
            ->assertSee('Inquiries');

        Livewire::withQueryParams([])
            ->test(InquiryManager::class)
            ->call('selectInquiry', 1)
            ->assertSet('selectedId', 1);
    }

    private function rateLimitKey(string $email): string
    {
        return 'contact-inquiry:'.sha1('127.0.0.1|'.strtolower(trim($email)));
    }
}

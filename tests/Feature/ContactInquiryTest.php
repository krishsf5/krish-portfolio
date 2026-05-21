<?php

namespace Tests\Feature;

use App\Livewire\Inquiries\InquiryManager;
use App\Livewire\Public\ContactSection;
use App\Mail\ContactInquiryReceived;
use App\Models\About;
use App\Models\ContactInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class ContactInquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear($this->rateLimitKey('person@example.com'));
        RateLimiter::clear($this->rateLimitKey('ownerless@example.com'));
        RateLimiter::clear($this->rateLimitKey('throttle@example.com'));
    }

    public function test_homepage_renders_contact_section_and_nav_link(): void
    {
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

    public function test_successful_submission_creates_inquiry_and_sends_owner_email(): void
    {
        Mail::fake();

        About::create([
            'full_name' => 'Krish Bhojwani',
            'title' => 'Software Engineer',
            'email' => 'owner@example.com',
            'availability' => 'available',
        ]);

        Livewire::test(ContactSection::class)
            ->set('name', 'Test Person')
            ->set('email', 'person@example.com')
            ->set('message', 'I would like to discuss a Laravel project with you.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Thanks, your message has been sent.');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Test Person',
            'email' => 'person@example.com',
            'status' => ContactInquiry::STATUS_UNREAD,
        ]);

        Mail::assertSent(ContactInquiryReceived::class, function (ContactInquiryReceived $mail) {
            return $mail->hasTo('owner@example.com')
                && $mail->inquiry->email === 'person@example.com';
        });
    }

    public function test_submission_without_about_email_still_saves_without_email(): void
    {
        Mail::fake();

        Livewire::test(ContactSection::class)
            ->set('name', 'Ownerless Person')
            ->set('email', 'ownerless@example.com')
            ->set('message', 'This should save even when no owner email exists.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Thanks, your message has been sent.');

        $this->assertDatabaseHas('contact_inquiries', [
            'email' => 'ownerless@example.com',
        ]);

        Mail::assertNothingSent();
    }

    public function test_honeypot_submission_is_silently_accepted_without_saving_or_mailing(): void
    {
        Mail::fake();

        Livewire::test(ContactSection::class)
            ->set('name', 'Bot Person')
            ->set('email', 'bot@example.com')
            ->set('message', 'This submission should be ignored because the honeypot is filled.')
            ->set('website', 'https://spam.example')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Thanks, your message has been sent.');

        $this->assertDatabaseCount('contact_inquiries', 0);
        Mail::assertNothingSent();
    }

    public function test_repeated_submissions_are_throttled(): void
    {
        Mail::fake();

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

        $this->assertDatabaseCount('contact_inquiries', 3);
    }

    public function test_guests_cannot_access_inquiry_dashboard(): void
    {
        $this->get(route('inquiries'))->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_manage_inquiry_status(): void
    {
        $user = User::factory()->create();
        $inquiry = ContactInquiry::create([
            'name' => 'Inbox Person',
            'email' => 'inbox@example.com',
            'message' => 'Please read and archive this dashboard inquiry.',
            'status' => ContactInquiry::STATUS_UNREAD,
        ]);

        $this->actingAs($user);

        $this->get(route('inquiries'))->assertOk()->assertSee('Inquiries');

        Livewire::test(InquiryManager::class)
            ->call('selectInquiry', $inquiry->id)
            ->assertSet('selectedId', $inquiry->id);

        $this->assertSame(ContactInquiry::STATUS_READ, $inquiry->refresh()->status);
        $this->assertNotNull($inquiry->read_at);

        Livewire::test(InquiryManager::class)
            ->call('markUnread', $inquiry->id);

        $this->assertSame(ContactInquiry::STATUS_UNREAD, $inquiry->refresh()->status);
        $this->assertNull($inquiry->read_at);

        Livewire::test(InquiryManager::class)
            ->call('archive', $inquiry->id);

        $this->assertSame(ContactInquiry::STATUS_ARCHIVED, $inquiry->refresh()->status);
        $this->assertNotNull($inquiry->archived_at);
    }

    private function rateLimitKey(string $email): string
    {
        return 'contact-inquiry:'.sha1('127.0.0.1|'.$email);
    }
}

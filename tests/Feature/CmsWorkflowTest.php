<?php

namespace Tests\Feature;

use App\Livewire\About\AboutManager;
use App\Livewire\Inquiries\InquiryManager;
use App\Livewire\Projects\ProjectManager;
use App\Livewire\Resume\ResumeManager;
use App\Livewire\Skills\SkillManager;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class CmsWorkflowTest extends TestCase
{
    private array $authSession;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authSession = [
            'api_token' => 'test-valid-bearer-token',
            'api_login_at' => time(),
            'api_user' => [
                'id' => 1,
                'name' => 'Krish Bhojwani',
                'email' => 'krishtbhojwani@gmail.com',
            ],
        ];

        session($this->authSession);
    }

    public function test_unauthenticated_users_are_redirected_from_all_cms_routes(): void
    {
        session()->flush();
        $cmsRoutes = ['dashboard', 'skills', 'about', 'resume', 'inquiries'];

        foreach ($cmsRoutes as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
    }

    public function test_login_authenticates_and_stores_session(): void
    {
        Http::fake([
            '*/admin/login' => Http::response([
                'token' => 'mock-jwt-token',
                'user' => ['id' => 1, 'name' => 'Krish', 'email' => 'krishtbhojwani@gmail.com'],
            ], 200),
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'krishtbhojwani@gmail.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('mock-jwt-token', session('api_token'));
    }

    public function test_logout_clears_session(): void
    {
        Http::fake([
            '*/admin/logout' => Http::response(['message' => 'Logged out.'], 200),
        ]);

        $response = $this->withSession($this->authSession)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertNull(session('api_token'));
        $this->assertNull(session('api_user'));
    }

    public function test_dashboard_renders_stats_and_project_manager(): void
    {
        Http::fake([
            '*/admin/projects' => Http::response([
                ['id' => 1, 'title' => 'Project One', 'status' => 'live', 'is_visible' => true],
                ['id' => 2, 'title' => 'Project Two', 'status' => 'wip', 'is_visible' => true],
            ], 200),
        ]);

        $this->withSession($this->authSession)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Total Projects')
            ->assertSee('Live Projects');
    }

    public function test_skills_manager_lists_and_saves_skills(): void
    {
        Http::fake([
            '*/admin/skills' => Http::response([
                [
                    'id' => 1,
                    'name' => 'PHP 8.4',
                    'category' => 'Backend',
                    'proficiency' => 95,
                    'icon' => null,
                    'is_visible' => true,
                    'sort_order' => 1,
                ],
            ], 200),
            '*/admin/skills/1/toggle' => Http::response(['id' => 1, 'is_visible' => false], 200),
        ]);

        $component = Livewire::withQueryParams([])
            ->test(SkillManager::class)
            ->assertSee('PHP 8.4');

        $component->call('toggleVisibility', 1);
    }

    public function test_projects_manager_lists_projects(): void
    {
        Http::fake([
            '*/admin/projects' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Portfolio CMS',
                    'slug' => 'portfolio-cms',
                    'description' => 'Test description',
                    'status' => 'live',
                    'is_visible' => true,
                    'tags' => ['Laravel', 'Livewire'],
                    'media' => [],
                    'thumbnail' => null,
                ],
            ], 200),
        ]);

        Livewire::withQueryParams([])
            ->test(ProjectManager::class)
            ->assertSee('Portfolio CMS');
    }

    public function test_about_manager_renders_and_updates_profile(): void
    {
        Http::fake([
            '*/api/about' => Http::response([
                'about' => [
                    'id' => 1,
                    'full_name' => 'Krish Bhojwani',
                    'title' => 'Software Engineer',
                    'bio' => 'Building scalable systems',
                    'location' => 'Mumbai, India',
                    'email' => 'krishtbhojwani@gmail.com',
                    'availability' => 'available',
                    'years_experience' => 3,
                    'stats' => [],
                ],
                'avatar_url' => null,
            ], 200),
            '*/admin/projects' => Http::response([], 200),
            '*/admin/about' => Http::response(['id' => 1, 'full_name' => 'Krish Bhojwani Updated'], 200),
        ]);

        $component = Livewire::withQueryParams([])
            ->test(AboutManager::class)
            ->assertSet('full_name', 'Krish Bhojwani')
            ->set('full_name', 'Krish Bhojwani Updated')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('', $component->get('error'));
    }

    public function test_resume_manager_renders_resumes_without_date_errors(): void
    {
        Http::fake([
            '*/admin/resume' => Http::response([
                [
                    'id' => 1,
                    'filename' => 'Krish_Resume_2026.pdf',
                    'path' => 'resumes/abc.pdf',
                    'size_kb' => 150,
                    'is_active' => true,
                    'created_at' => '2026-09-20T04:00:00.000000Z',
                ],
            ], 200),
        ]);

        Livewire::withQueryParams([])
            ->test(ResumeManager::class)
            ->assertSee('Krish_Resume_2026.pdf')
            ->assertSee('Sep 20, 2026');
    }

    public function test_inquiries_manager_renders_and_handles_dates(): void
    {
        Http::fake([
            '*/admin/inquiries*' => Http::response([
                'inquiries' => [
                    [
                        'id' => 1,
                        'name' => 'John Doe',
                        'email' => 'john@example.com',
                        'message' => 'Hello there',
                        'status' => 'unread',
                        'created_at' => '2026-09-20 02:00:00',
                        'read_at' => null,
                        'archived_at' => null,
                    ],
                ],
                'unread_count' => 1,
            ], 200),
        ]);

        Livewire::withQueryParams([])
            ->test(InquiryManager::class)
            ->assertSee('John Doe')
            ->assertSee('john@example.com');
    }
}

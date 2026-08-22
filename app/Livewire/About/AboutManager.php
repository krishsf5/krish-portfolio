<?php

namespace App\Livewire\About;

use App\Services\ApiClient;
use App\Services\AuthApiService;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Dashboard — About')]
class AboutManager extends Component
{
    use WithFileUploads;

    public ?int $aboutId = null;

    #[Validate('required|string|max:100')]
    public string $full_name = '';

    #[Validate('required|string|max:100')]
    public string $title = '';

    #[Validate('nullable|string')]
    public string $bio = '';

    #[Validate('nullable|string|max:100')]
    public string $location = '';

    #[Validate('nullable|email|max:150')]
    public string $email = '';

    #[Validate('nullable|url|max:255')]
    public string $github_url = '';

    #[Validate('nullable|url|max:255')]
    public string $linkedin_url = '';

    #[Validate('nullable|url|max:255')]
    public string $website_url = '';

    #[Validate('nullable|integer|min:0|max:50')]
    public int $years_experience = 0;

    #[Validate('required|in:available,open,unavailable')]
    public string $availability = 'available';

    #[Validate('nullable|image|max:5120')]
    public $avatar = null;

    public ?string $existingAvatar = null;

    public array $stats = [];

    public string $error = '';

    public function mount(): void
    {
        $response = ApiClient::get('/about');
        if ($response->successful()) {
            $data = $response->json();
            $about = $data['about'] ?? null;
            $this->existingAvatar = $data['avatar_url'] ?? null;

            if ($about) {
                $this->aboutId          = $about['id'] ?? null;
                $this->full_name        = $about['full_name'] ?? '';
                $this->title            = $about['title'] ?? '';
                $this->bio              = $about['bio'] ?? '';
                $this->location         = $about['location'] ?? '';
                $this->email            = $about['email'] ?? '';
                $this->github_url       = $about['github_url'] ?? '';
                $this->linkedin_url     = $about['linkedin_url'] ?? '';
                $this->website_url      = $about['website_url'] ?? '';
                $this->years_experience = $about['years_experience'] ?? 0;
                $this->availability     = $about['availability'] ?? 'available';
                $this->stats            = is_array($about['stats'] ?? null) ? $about['stats'] : [];
            }
        }
    }

    public function save(): void
    {
        $this->validate();

        $cleanStats = array_values(array_filter($this->stats, function ($s) {
            return ! empty(trim($s['label'] ?? '')) && ! empty(trim($s['value'] ?? ''));
        }));

        $data = [
            'full_name'        => trim($this->full_name),
            'title'            => trim($this->title),
            'bio'              => trim($this->bio) ?: null,
            'location'         => trim($this->location) ?: null,
            'email'            => trim($this->email) ?: null,
            'github_url'       => trim($this->github_url) ?: null,
            'linkedin_url'     => trim($this->linkedin_url) ?: null,
            'website_url'      => trim($this->website_url) ?: null,
            'years_experience' => (int) $this->years_experience,
            'availability'     => $this->availability,
            'stats'            => ! empty($cleanStats) ? $cleanStats : null,
        ];

        $response = $this->avatar
            ? ApiClient::putMultipart('/admin/about', array_merge($data, ['avatar' => $this->avatar]))
            : ApiClient::put('/admin/about', $data);

        if ($response->successful()) {
            Cache::forget('public.about_data');
            $this->stats = $cleanStats;
            $this->avatar = null;
            $this->error = '';

            // Refresh about data and avatar_url from API
            $aboutRes = ApiClient::get('/about');
            if ($aboutRes->successful()) {
                $aboutData = $aboutRes->json();
                $this->existingAvatar = $aboutData['avatar_url'] ?? null;
            }

            session()->flash('success', 'Profile updated successfully.');
        } else {
            $this->error = $response->json('message', 'Failed to update profile.');
        }
    }

    public function addStat(): void
    {
        $this->stats[] = ['label' => '', 'value' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->stats[$index]);
        $this->stats = array_values($this->stats);
    }

    public function render()
    {
        $user = AuthApiService::user();

        $projectsResponse = ApiClient::get('/admin/projects');
        $projects = $projectsResponse->successful() ? collect(json_decode($projectsResponse->body())) : collect();
        $liveProjectCount = $projects->where('status', 'live')->where('is_visible', true)->count();

        return view('livewire.admin.about.about-manager', [
            'about'            => $this,
            'existingAvatar'   => $this->existingAvatar,
            'authUser'         => $user,
            'liveProjectCount' => $liveProjectCount,
        ])->layout('layouts.dashboard');
    }
}

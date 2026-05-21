<?php

namespace App\Livewire\About;

use App\Models\About;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
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

    #[Validate('nullable|image|max:2048')]
    public $avatar = null;

    public ?string $existingAvatar = null;

    // Stats: array of ['label' => '', 'value' => '']
    public array $stats = [];

    public function mount(): void
    {
        $about = About::first();

        if ($about) {
            $this->aboutId = $about->id;
            $this->full_name = $about->full_name;
            $this->title = $about->title;
            $this->bio = $about->bio ?? '';
            $this->location = $about->location ?? '';
            $this->email = $about->email ?? '';
            $this->github_url = $about->github_url ?? '';
            $this->linkedin_url = $about->linkedin_url ?? '';
            $this->website_url = $about->website_url ?? '';
            $this->years_experience = $about->years_experience ?? 0;
            $this->availability = $about->availability;
            $this->existingAvatar = $about->avatar;
            $this->stats = $about->stats ?? [];
        }
    }

    public function addStat(): void
    {
        $this->stats[] = ['label' => '', 'value' => ''];
    }

    public function removeStat(int $index): void
    {
        array_splice($this->stats, $index, 1);
        $this->stats = array_values($this->stats);
    }

    public function save(): void
    {
        $this->validate();

        // Clean out any empty stat rows
        $cleanStats = collect($this->stats)
            ->filter(fn ($s) => filled($s['label'] ?? null) && filled($s['value'] ?? null))
            ->map(fn ($s) => [
                'label' => trim($s['label']),
                'value' => trim($s['value']),
            ])
            ->values()
            ->toArray();

        $data = [
            'full_name' => trim($this->full_name),
            'title' => trim($this->title),
            'bio' => trim($this->bio) ?: null,
            'location' => trim($this->location) ?: null,
            'email' => trim($this->email) ?: null,
            'github_url' => trim($this->github_url) ?: null,
            'linkedin_url' => trim($this->linkedin_url) ?: null,
            'website_url' => trim($this->website_url) ?: null,
            'years_experience' => $this->years_experience,
            'availability' => $this->availability,
            'stats' => $cleanStats,
        ];

        if ($this->avatar) {
            if ($this->existingAvatar) {
                Storage::disk('public')->delete($this->existingAvatar);
            }
            $data['avatar'] = $this->avatar->store('about', 'public');
        }

        if ($this->aboutId) {
            About::findOrFail($this->aboutId)->update($data);
        } else {
            $about = About::create($data);
            $this->aboutId = $about->id;
        }

        $this->stats = About::find($this->aboutId)?->stats ?? [];
        $this->existingAvatar = About::find($this->aboutId)?->avatar;
        $this->avatar = null;

        Cache::forget('public.about');

        session()->flash('success', 'About section saved.');
    }

    public function render()
    {
        return view('livewire.admin.about.about-manager', [
            'liveProjectCount' => Project::where('status', 'live')
                ->where('is_visible', true)
                ->count(),
        ])->layout('layouts.dashboard');
    }
}

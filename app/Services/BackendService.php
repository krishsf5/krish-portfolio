<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Public-facing data service.
 * All calls are HMAC-signed via ApiClient — no DB access on the frontend.
 */
class BackendService
{
    public static function getAbout(): mixed
    {
        return Cache::remember('public.about_data', 300, function () {
            try {
                $response = ApiClient::get('/about');
                if ($response->successful()) {
                    return json_decode($response->body());
                }
            } catch (\Exception) {}
            return null;
        });
    }

    public static function getProjects(): \Illuminate\Support\Collection
    {
        return Cache::remember('public.projects', 300, function () {
            try {
                $response = ApiClient::get('/projects');
                if ($response->successful()) {
                    return collect(json_decode($response->body()));
                }
            } catch (\Exception) {}
            return collect();
        });
    }

    public static function getProject(string $slug): mixed
    {
        try {
            $response = ApiClient::get("/projects/{$slug}");
            if ($response->successful()) {
                return json_decode($response->body());
            }
        } catch (\Exception) {}
        abort(404);
    }

    public static function getSkills(): \Illuminate\Support\Collection
    {
        return Cache::remember('public.skills', 300, function () {
            try {
                $response = ApiClient::get('/skills');
                if ($response->successful()) {
                    return collect(json_decode($response->body()));
                }
            } catch (\Exception) {}
            return collect();
        });
    }

    public static function getResume(): mixed
    {
        return Cache::remember('public.resume_data', 300, function () {
            try {
                $response = ApiClient::get('/resumes');
                if ($response->successful()) {
                    return json_decode($response->body());
                }
            } catch (\Exception) {}
            return null;
        });
    }

    public static function submitInquiry(array $data): bool
    {
        try {
            $response = ApiClient::post('/inquiries', $data);
            return $response->successful();
        } catch (\Exception) {
            return false;
        }
    }
}

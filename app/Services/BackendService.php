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
        if (Cache::has('public.about_data')) {
            return Cache::get('public.about_data');
        }

        try {
            $response = ApiClient::get('/about');
            if ($response->successful()) {
                $data = json_decode($response->body());
                if ($data) {
                    Cache::put('public.about_data', $data, 300);
                    return $data;
                }
            }
        } catch (\Exception) {}

        return null;
    }

    public static function getProjects(): \Illuminate\Support\Collection
    {
        if (Cache::has('public.projects')) {
            return Cache::get('public.projects');
        }

        try {
            $response = ApiClient::get('/projects');
            if ($response->successful()) {
                $data = collect(json_decode($response->body()));
                if ($data->isNotEmpty()) {
                    Cache::put('public.projects', $data, 300);
                }
                return $data;
            }
        } catch (\Exception) {}

        return collect();
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
        if (Cache::has('public.skills')) {
            return Cache::get('public.skills');
        }

        try {
            $response = ApiClient::get('/skills');
            if ($response->successful()) {
                $data = collect(json_decode($response->body()));
                if ($data->isNotEmpty()) {
                    Cache::put('public.skills', $data, 300);
                }
                return $data;
            }
        } catch (\Exception) {}

        return collect();
    }

    public static function getResume(): mixed
    {
        if (Cache::has('public.resume_data')) {
            return Cache::get('public.resume_data');
        }

        try {
            $response = ApiClient::get('/resumes');
            if ($response->successful()) {
                $data = json_decode($response->body());
                if ($data) {
                    Cache::put('public.resume_data', $data, 300);
                    return $data;
                }
            }
        } catch (\Exception) {}

        return null;
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

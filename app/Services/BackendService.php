<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BackendService
{
    protected static function getBaseUrl(): string
    {
        return rtrim(config('services.backend.url', env('BACKEND_API_URL', 'http://localhost:8001/api')), '/');
    }

    public static function getAbout()
    {
        return Cache::remember('public.about_data', 300, function () {
            try {
                $response = Http::timeout(5)->get(self::getBaseUrl() . '/about');
                if ($response->successful()) {
                    return json_decode($response->body());
                }
            } catch (\Exception $e) {
                // Fallback or log
            }
            return null;
        });
    }

    public static function getProjects()
    {
        return Cache::remember('public.projects', 300, function () {
            try {
                $response = Http::timeout(5)->get(self::getBaseUrl() . '/projects');
                if ($response->successful()) {
                    return collect(json_decode($response->body()));
                }
            } catch (\Exception $e) {
                // Fallback
            }
            return collect();
        });
    }

    public static function getProject(string $slug)
    {
        try {
            $response = Http::timeout(5)->get(self::getBaseUrl() . "/projects/{$slug}");
            if ($response->successful()) {
                return json_decode($response->body());
            }
        } catch (\Exception $e) {
            // Fallback
        }
        abort(404);
    }

    public static function getSkills()
    {
        return Cache::remember('public.skills', 300, function () {
            try {
                $response = Http::timeout(5)->get(self::getBaseUrl() . '/skills');
                if ($response->successful()) {
                    return collect(json_decode($response->body()));
                }
            } catch (\Exception $e) {
                // Fallback
            }
            return collect();
        });
    }

    public static function getResume()
    {
        return Cache::remember('public.resume_data', 300, function () {
            try {
                $response = Http::timeout(5)->get(self::getBaseUrl() . '/resumes');
                if ($response->successful()) {
                    return json_decode($response->body());
                }
            } catch (\Exception $e) {
                // Fallback
            }
            return null;
        });
    }

    public static function submitInquiry(array $data): bool
    {
        try {
            $response = Http::timeout(5)->post(self::getBaseUrl() . '/inquiries', $data);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}

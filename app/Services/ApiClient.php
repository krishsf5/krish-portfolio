<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Central HTTP client for all backend API communication.
 *
 * Security layers applied on every request:
 *  1. HMAC-SHA256 signature  — key lives only in PHP env, never reaches the browser.
 *  2. X-Timestamp header     — prevents replay attacks (backend rejects if > 30s old).
 *  3. AES-256-GCM encryption — for sensitive write payloads (login, mutations).
 *  4. Bearer token           — for authenticated (admin) routes, stored in PHP session.
 */
class ApiClient
{
    // ─── Configuration ────────────────────────────────────────────────────────

    private static function baseUrl(): string
    {
        return rtrim(config('services.backend.url', env('BACKEND_API_URL', 'http://localhost:8001/api')), '/');
    }

    private static function hmacSecret(): string
    {
        return config('services.hmac.secret', '');
    }

    private static function encryptKey(): string
    {
        return config('services.encrypt.key', '');
    }

    // ─── Signature ─────────────────────────────────────────────────────────────

    /**
     * Build canonical string and compute HMAC-SHA256 signature.
     * The key is PHP-side only — it is never serialised into JS or HTTP responses.
     */
    private static function buildSignature(string $method, string $path, string $rawBody, int $timestamp): string
    {
        $bodyHash  = hash('sha256', $rawBody);
        
        // Normalize path so it always has the /api/ prefix to match Laravel's $request->path()
        $cleanPath = ltrim($path, '/');
        if (! str_starts_with($cleanPath, 'api/')) {
            $cleanPath = 'api/' . $cleanPath;
        }
        $canonicalPath = '/' . $cleanPath;

        $canonical = implode("\n", [$timestamp, strtoupper($method), $canonicalPath, $bodyHash]);

        return hash_hmac('sha256', $canonical, self::hmacSecret());
    }

    // ─── Encryption ────────────────────────────────────────────────────────────

    /**
     * Encrypt a payload array using AES-256-GCM.
     * Returns a JSON envelope: { "enc": "<base64-ciphertext>", "iv": "<base64-iv>", "tag": "<base64-tag>" }
     * The key never leaves the frontend PHP server.
     */
    public static function encrypt(array $payload): string
    {
        $key    = hex2bin(self::encryptKey());
        $iv     = random_bytes(12);              // 96-bit IV for GCM
        $cipher = openssl_encrypt(
            json_encode($payload),
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16
        );

        return json_encode([
            'enc' => base64_encode($cipher),
            'iv'  => base64_encode($iv),
            'tag' => base64_encode($tag),
        ]);
    }

    // ─── Core Request ──────────────────────────────────────────────────────────

    /**
     * Make a signed HTTP request to the backend API.
     *
     * @param  string  $method       HTTP verb (GET, POST, PUT, PATCH, DELETE)
     * @param  string  $path         API path e.g. "/skills" (no base URL)
     * @param  array   $data         Request payload
     * @param  bool    $encrypt      Whether to AES-encrypt the payload
     * @param  bool    $multipart    Whether to send as multipart/form-data (file uploads)
     */
    public static function request(
        string $method,
        string $path,
        array $data = [],
        bool $encrypt = false,
        bool $multipart = false,
    ): Response {
        $timestamp = time();
        $method    = strtoupper($method);

        // Determine raw body for signature computation
        if ($multipart || empty($data)) {
            $rawBody = '';
        } elseif ($encrypt) {
            $rawBody = self::encrypt($data);
        } else {
            $rawBody = json_encode($data, JSON_UNESCAPED_SLASHES);
        }

        $signature = self::buildSignature($method, $path, $rawBody, $timestamp);

        // Build the pending request
        $http = Http::timeout(15)
            ->withHeaders([
                'X-Signature' => $signature,
                'X-Timestamp' => (string) $timestamp,
                'Accept'      => 'application/json',
            ]);

        // Attach bearer token if one is stored in session (admin routes)
        $token = session('api_token');
        if ($token) {
            $http = $http->withToken($token);
        }

        $url = self::baseUrl() . '/' . ltrim($path, '/');

        // Send request
        if ($multipart) {
            // File upload — attach each field individually
            $pending = $http->asMultipart();
            foreach ($data as $key => $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $pending = $pending->attach($key, $value->get(), $value->getClientOriginalName());
                } else {
                    $pending = $pending->attach($key, (string) $value);
                }
            }
            return $pending->$method($url);
        }

        if ($encrypt && ! empty($data)) {
            // Send encrypted envelope as raw JSON body
            return $http->withBody($rawBody, 'application/json')->$method($url);
        }

        return match ($method) {
            'GET', 'DELETE' => $http->$method($url, $data ?: null),
            default         => $http->$method($url, empty($data) ? [] : json_decode($rawBody, true)),
        };
    }

    // ─── Convenience Helpers ───────────────────────────────────────────────────

    public static function get(string $path, array $query = []): Response
    {
        return self::request('GET', $path, $query);
    }

    public static function post(string $path, array $data = [], bool $encrypt = false): Response
    {
        return self::request('POST', $path, $data, $encrypt);
    }

    public static function postMultipart(string $path, array $data = []): Response
    {
        return self::request('POST', $path, $data, false, true);
    }

    public static function put(string $path, array $data = [], bool $encrypt = false): Response
    {
        return self::request('PUT', $path, $data, $encrypt);
    }

    public static function putMultipart(string $path, array $data = []): Response
    {
        return self::request('PUT', $path, $data, false, true);
    }

    public static function patch(string $path, array $data = []): Response
    {
        return self::request('PATCH', $path, $data);
    }

    public static function delete(string $path): Response
    {
        return self::request('DELETE', $path);
    }
}

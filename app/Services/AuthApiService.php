<?php

namespace App\Services;

class AuthApiService
{
    private const SESSION_TOKEN      = 'api_token';
    private const SESSION_USER       = 'api_user';
    private const SESSION_LOGIN_TIME = 'api_login_at';

    /**
     * Session expires automatically after 1 hour (3600 seconds)
     */
    public const MAX_SESSION_LIFETIME = 3600;

    public static function login(string $email, string $password): bool
    {
        try {
            $response = ApiClient::post('/admin/login', [
                'email'    => $email,
                'password' => $password,
            ], encrypt: true);

            if ($response->successful()) {
                $data = $response->json();
                session([
                    self::SESSION_TOKEN      => $data['token'],
                    self::SESSION_USER       => $data['user'],
                    self::SESSION_LOGIN_TIME => time(),
                ]);
                return true;
            }
        } catch (\Exception) {}

        return false;
    }

    public static function logout(): void
    {
        try {
            if (session(self::SESSION_TOKEN)) {
                ApiClient::post('/admin/logout');
            }
        } catch (\Exception) {}

        session()->forget([
            self::SESSION_TOKEN,
            self::SESSION_USER,
            self::SESSION_LOGIN_TIME,
        ]);
    }

    public static function token(): ?string
    {
        if (self::isExpired()) {
            self::logout();
            return null;
        }

        return session(self::SESSION_TOKEN);
    }

    public static function user(): ?array
    {
        if (self::isExpired()) {
            self::logout();
            return null;
        }

        return session(self::SESSION_USER);
    }

    public static function check(): bool
    {
        return ! empty(self::token());
    }

    public static function isExpired(): bool
    {
        $loginAt = session(self::SESSION_LOGIN_TIME);
        if (! $loginAt) {
            return false;
        }

        return (time() - (int) $loginAt) > self::MAX_SESSION_LIFETIME;
    }
}

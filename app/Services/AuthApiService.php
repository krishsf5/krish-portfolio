<?php

namespace App\Services;

class AuthApiService
{
    private const SESSION_TOKEN = 'api_token';
    private const SESSION_USER  = 'api_user';

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
                    self::SESSION_TOKEN => $data['token'],
                    self::SESSION_USER  => $data['user'],
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

        session()->forget([self::SESSION_TOKEN, self::SESSION_USER]);
    }

    public static function token(): ?string
    {
        return session(self::SESSION_TOKEN);
    }

    public static function user(): ?array
    {
        return session(self::SESSION_USER);
    }

    public static function check(): bool
    {
        return ! empty(self::token());
    }
}

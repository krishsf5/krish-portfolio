<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
{
    /**
     * Show the login form.
     * Redirect to dashboard if already authenticated.
     */
    public function showLoginForm()
    {
        if (AuthApiService::check()) {
            return redirect()->route('dashboard');
        }

        return view('pages::auth.login');
    }

    /**
     * Handle login form submission.
     * Calls backend API with encrypted credentials, stores token in PHP session.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rate-limit: 5 attempts per minute per IP
        $key = 'login_attempts_' . sha1($request->ip());
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please wait {$seconds} seconds.",
            ])->onlyInput('email');
        }

        if (AuthApiService::login($credentials['email'], $credentials['password'])) {
            \Illuminate\Support\Facades\RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out.
     * Revokes the backend token and clears the PHP session.
     */
    public function logout(Request $request): RedirectResponse
    {
        AuthApiService::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

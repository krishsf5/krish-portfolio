<?php

namespace App\Http\Middleware;

use App\Services\AuthApiService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Protects dashboard routes by checking for a valid API token in session.
 * No database queries — purely session-based.
 */
class ApiAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! AuthApiService::check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}

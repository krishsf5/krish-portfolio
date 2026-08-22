<?php

namespace App\Http\Middleware;

use App\Services\AuthApiService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! AuthApiService::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            session()->flash('error', 'Please log in to access the dashboard.');
            return redirect()->route('login');
        }

        return $next($request);
    }
}

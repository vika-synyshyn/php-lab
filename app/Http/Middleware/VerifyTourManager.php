<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTourManager
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->role === 'manager', 403);

        $response = $next($request);

        $response->headers->set(
            'X-Security-Policy',
            'TourManagerVerified'
        );

        return $response;
    }
}

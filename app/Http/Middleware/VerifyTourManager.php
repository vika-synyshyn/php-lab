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
        // Перевірка ролі під час створення туристичного туру
        if (
            $request->isMethod('post') &&
            $request->header('X-Tour-Role') !== 'manager'
        ) {
            return response()->json([
                'status' => 'access_denied',
                'message' => 'Створювати туристичні пропозиції може лише менеджер.',
            ], 403);
        }

        // Передавання дозволеного запиту наступному компоненту
        $response = $next($request);

        // Додавання службового заголовка до відповіді
        $response->headers->set(
            'X-Security-Policy',
            'TourManagerVerified'
        );

        return $response;
    }
}

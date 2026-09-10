<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceSecureSpaCookies
{
    public function handle(Request $request, Closure $next): Response
    {
        $isHttps = $request->isSecure()
            || strtolower((string) $request->header('X-Forwarded-Proto')) === 'https';

        if (app()->environment('production') || $isHttps) {
            config([
                'session.secure' => true,
                'session.same_site' => 'none',
            ]);
        }

        return $next($request);
    }
}

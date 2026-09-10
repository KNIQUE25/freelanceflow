<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->prepend(
            \App\Http\Middleware\ForceSecureSpaCookies::class
        );

        /*
        |--------------------------------------------------------------------------
        | Sanctum SPA Authentication
        |--------------------------------------------------------------------------
        */

        $middleware->statefulApi();

        /*
        |--------------------------------------------------------------------------
        | Admin Middleware
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Authentication redirect
        |--------------------------------------------------------------------------
        */

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return null;
            }

            return config('app.frontend_url', '/');
        });
    })

    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            Request $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        });
    })

    ->create();
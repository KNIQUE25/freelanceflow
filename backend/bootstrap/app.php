<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Sanctum SPA Authentication
        |--------------------------------------------------------------------------
        */
        $middleware->statefulApi();

        /*
        |--------------------------------------------------------------------------
        | Start Laravel sessions for API requests
        |--------------------------------------------------------------------------
        |
        | AuthController uses Auth::attempt(), session()->regenerate(),
        | logout(), etc. Therefore the API requests need a session.
        |
        */
        $middleware->appendToGroup('api', [
            StartSession::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Middleware
        |--------------------------------------------------------------------------
        */
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
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
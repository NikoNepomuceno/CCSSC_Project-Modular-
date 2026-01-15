<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'jwt.auth' => \App\Http\Middleware\ValidateAccessToken::class,
            'api.csrf' => \App\Http\Middleware\VerifyApiCsrf::class,
        ]);

        // Configure redirect for unauthenticated users
        $middleware->redirectGuestsTo(function ($request) {
            // Redirect admin routes to admin login
            if (str_starts_with($request->path(), config('admin.slug', 'admin'))) {
                return route('admin.login');
            }

            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

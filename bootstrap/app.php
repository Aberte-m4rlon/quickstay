<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            // global web middleware here
        ]);

        $middleware->api([
            // global api middleware here
        ]);

       // inside ->withMiddleware(...)
    $middleware->alias([
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Add this line:
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\OfficerPositionMiddleware;
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
    ->withMiddleware(function (Middleware $middleware): void {
        // Register global middleware
        $middleware->web(append: [
            // Global web middleware here
        ]);

        // Register route middleware
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'position' => OfficerPositionMiddleware::class,
            // Other middleware aliases...
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

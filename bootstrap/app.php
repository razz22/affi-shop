<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// The public/ folder was flattened into the project root (index.php, .htaccess,
// and build/ all live at the base path now), so Laravel's public path must
// match — otherwise public_path('build/manifest.json') etc. resolve wrong.
$app->usePublicPath(dirname(__DIR__));

return $app;

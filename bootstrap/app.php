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
        $middleware->alias([
            'check_status' => \App\Http\Middleware\CheckAccountStatus::class,
            'force.https' => \App\Http\Middleware\ForceHttps::class,
        ]);

        // Force HTTPS in production
        $middleware->web(append: [
            \App\Http\Middleware\ForceHttps::class,
        ]);

        $middleware->redirectTo(
            guests: function (\Illuminate\Http\Request $request) {
                if ($request->is('admin') || $request->is('admin/*')) {
                    return route('admin.login');
                }
                if ($request->is('entreprise') || $request->is('entreprise/*')) {
                    return route('entreprise.login');
                }
                return route('login'); // default candidat login
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

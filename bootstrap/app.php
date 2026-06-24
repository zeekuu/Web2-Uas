<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
        'role' => RoleMiddleware::class,
    ]);
    $middleware->redirectUsersTo(function () {
            $user = Auth::user();

            if ($user) {
                if ($user->role === 'admin') {
                    return route('admin.dashboard');
                } elseif ($user->role === 'panitia') {
                    return route('panitia.dashboard');
                } elseif ($user->role === 'user') {
                    return route('user.dashboard');
                }
            }

            return route('404');
        });
})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();

    
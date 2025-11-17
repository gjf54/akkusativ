<?php

use App\Http\Middleware\AddBearerToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->statefulApi();

        $middleware->append([
            \Illuminate\Session\Middleware\StartSession::class,
        ]);

        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
            'api.set_token' => AddBearerToken::class,
        ]);

        $middleware->prependToGroup('api', [
            'api.set_token',
        ]);

        $middleware->prependToGroup('broadcast', [
            'api.set_token',
        ]);

        $middleware->appendToGroup('broadcast', [
            'auth:sanctum',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

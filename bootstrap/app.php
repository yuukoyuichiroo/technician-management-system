<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UpgradeToHttpsUnderNgrok;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('web', [
            UpgradeToHttpsUnderNgrok::class, // <--- Tambahkan di sini
        ]);

        // Jika Anda ingin menggunakannya sebagai alias
        // $middleware->alias([
        //     'https.ngrok' => UpgradeToHttpsUnderNgrok::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

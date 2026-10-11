<?php

use Illuminate\Console\Scheduling\Schedule;
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
        // Force an immediate 401 response instead of seeking a 'login' route redirect.
        $middleware->redirectTo(fn () => abort(401, 'Unauthenticated.'));

        // Apply CORS headers to every response (including redirects and
        // non-API routes) so cross-origin requests never fail CORS checks.
        $middleware->prepend(\App\Http\Middleware\HandleCors::class);

        $middleware->web(prepend: [
            \App\Http\Middleware\UpdateLastSeen::class,
        ]);
        
        $middleware->api(prepend: [
            // Force JSON negotiation so validation errors return 422 JSON
            // instead of a 302 redirect (which would break CORS in the browser).
            \App\Http\Middleware\ForceAcceptJson::class,
            \App\Http\Middleware\CheckInactivity::class,
            \App\Http\Middleware\UpdateLastSeen::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'subscription.check' => \App\Http\Middleware\CheckSubscription::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('case-reminders:send-due')
            ->dailyAt('01:00')
            ->withoutOverlapping(2)
            ->onFailure(function () {
                \Illuminate\Support\Facades\Log::error('case-reminders:send-due command failed');
            })
            ->onSuccess(function () {
                \Illuminate\Support\Facades\Log::info('case-reminders:send-due command completed successfully');
            });

        $schedule->command('case-reminders:retry-failed', ['--max-retries=3'])
            ->dailyAt('02:00')
            ->withoutOverlapping(2);

        $schedule->command('case-reminders:health-check')
            ->dailyAt('03:00')
            ->withoutOverlapping();

        $schedule->command('subscriptions:verify-pending')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->onFailure(function () {
                \Illuminate\Support\Facades\Log::error('subscriptions:verify-pending command failed');
            })
            ->onSuccess(function () {
                \Illuminate\Support\Facades\Log::info('subscriptions:verify-pending command completed successfully');
            });

        $schedule->command('subscriptions:expire')
            ->hourly()
            ->withoutOverlapping()
            ->onFailure(function () {
                \Illuminate\Support\Facades\Log::error('subscriptions:expire command failed');
            })
            ->onSuccess(function () {
                \Illuminate\Support\Facades\Log::info('subscriptions:expire command completed successfully');
            });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Schedule::class, function ($app) {
            return tap(new Schedule, function ($schedule) {
                $schedule->command('products:delete-low-stock')->weeklyOn(1, '00:00');
            });
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

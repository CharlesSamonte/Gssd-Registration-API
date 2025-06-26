<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $limits = [
            'access-code' => ['limit' => 10, 'minutes' => 1],
            'db-access' => ['limit' => 30, 'minutes' => 60],
            'file-upload' => ['limit' => 10, 'minutes' => 1],
            'file-delete' => ['limit' => 10, 'minutes' => 1],
            'access-code-generate' => ['limit' => 3, 'minutes' => 1],
            'access-code-validate' => ['limit' => 10, 'minutes' => 1],
        ];

        foreach ($limits as $name => $config) {
            RateLimiter::for($name, function ($request) use ($config) {
                return Limit::perMinutes($config['minutes'], $config['limit'])->by($request->ip());
            });
        }
    }

}

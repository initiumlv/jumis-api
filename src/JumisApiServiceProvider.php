<?php

namespace Initium\Jumis\Api;

use Illuminate\Support\ServiceProvider;

class JumisApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/jumis.php', 'jumis'
        );

        $this->app->singleton(ApiService::class, function ($app) {
            return new ApiService(
                config('jumis.url'),
                config('jumis.username'),
                config('jumis.password'),
                config('jumis.version')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/jumis.php' => config_path('jumis.php'),
        ], 'jumis-config');
    }
} 
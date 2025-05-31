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
        $this->mergeConfigFrom(__DIR__.'/../config/jumis.php', 'jumis');

        $this->app->singleton(JumisAPIService::class, function ($app) {
            return new JumisAPIService(
                config('jumis.url'),
                config('jumis.username'),
                config('jumis.password'),
                config('jumis.database'),
                config('jumis.apikey'),
                config('jumis.guzzle')
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
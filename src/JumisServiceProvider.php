<?php

namespace Initium\Jumis\Api;

use Illuminate\Support\ServiceProvider;
use Initium\Jumis\Api\Commands\PublishConfigCommand;

class JumisServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/jumis.php', 'jumis'
        );

        $this->app->singleton(ApiService::class, function ($app) {
            return new ApiService();
        });

        $this->commands([
            PublishConfigCommand::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/jumis.php' => config_path('jumis.php'),
            ], 'config');
        }
    }
} 
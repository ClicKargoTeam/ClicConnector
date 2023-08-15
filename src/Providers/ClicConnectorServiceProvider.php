<?php

namespace ClicKargoTeam\ClicConnector\Providers;

use ClicKargoTeam\ClicConnector\ClicConnect;
use Illuminate\Support\ServiceProvider;

class ClicConnectorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/clicconnect.php' => config_path('clicconnect.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/clicconnect.php',
            'clicconnect'
        );

        $this->registerService();
    }

    /**
     * @return void
     */
    private function registerService(): void
    {
        app()->singleton(ClicConnect::class);
        $this->app->bind('clicconnect', function () {
            return app()->make(ClicConnect::class);
        });
    }
}

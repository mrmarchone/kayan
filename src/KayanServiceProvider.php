<?php

namespace Mrmarchone\Kayan;

use \Illuminate\Support\ServiceProvider;

class KayanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'kayan');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/kayan'),
            __DIR__ . '/config/kayan.php' => config_path('kayan.php'),
        ], 'KayanPublishVendor');
    }

    public function register()
    {

    }
}

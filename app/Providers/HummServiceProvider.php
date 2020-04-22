<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Managers\HummManager;

class HummServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HummManager::class, function ($app) {
            return new HummManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [HummManager::class];
    }
}

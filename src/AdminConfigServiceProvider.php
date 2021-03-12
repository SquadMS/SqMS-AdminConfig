<?php

namespace SquadMS\AdminConfig;

use Illuminate\Support\ServiceProvider;
use SquadMS\AdminConfig\Providers\EventServiceProvider;

class AdminConfigServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Load Migrations */
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        
        /* Register Routes */
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
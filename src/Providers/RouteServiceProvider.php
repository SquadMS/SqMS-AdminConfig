<?php

namespace SquadMS\AdminConfig\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        /* Routes */
        $routesPath = __DIR__.'/../../routes';

        /* API routes */
        Route::group([
            'prefix'     => 'api',
            'middleware' => 'api',
        ], function () use ($routesPath) {
            $this->loadRoutesFrom($routesPath.'/api.php');
        });
    }
}

<?php

namespace SquadMS\AdminConfig\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry;
use SquadMS\AdminConfig\SquadMSModule;

class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        /* Validates a HEX color code (like from color inputs) */
        Validator::extend('color', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^#[a-f0-9]{6}$/i', $value) === 1;
        });
    }
}

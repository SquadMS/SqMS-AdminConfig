<?php

namespace SquadMS\AdminConfig\Providers;

use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry;
use SquadMS\AdminConfig\SquadMSModule;

class ModulesServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        SquadMSModuleRegistry::register(SquadMSModule::class);
    }
}

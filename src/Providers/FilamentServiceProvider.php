<?php

namespace SquadMS\AdminConfig\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use SquadMS\AdminConfig\Filament\Resources\AdminConfigResource;
use SquadMS\AdminConfig\Filament\Resources\ServerGroupResource;
use SquadMS\AdminConfig\Filament\Resources\ServerPermissionResource;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        AdminConfigResource::class,
        ServerGroupResource::class,
        ServerPermissionResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('sqms-adminconfig');
    }
}

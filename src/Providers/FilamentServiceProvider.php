<?php

namespace SquadMS\AdminConfig\Providers;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use SquadMS\AdminConfig\Filament\Resources\AdminConfigResource;

class FilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        AdminConfigResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('sqms-adminconfig');
    }
}

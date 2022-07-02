<?php

namespace SquadMS\AdminConfig;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelPackageTools\Package;
use SquadMS\AdminConfig\Events\Internal\AdminConfig\AdminConfigSaving;
use SquadMS\AdminConfig\Events\Internal\ServerGroup\ServerGroupRemovedPermission;
use SquadMS\AdminConfig\Filament\Resources\AdminConfigResource;
use SquadMS\AdminConfig\Filament\Resources\ServerGroupResource;
use SquadMS\AdminConfig\Filament\Resources\ServerPermissionResource;
use SquadMS\AdminConfig\Listeners\AdminConfig\ClearUsersMainGroupCache;
use SquadMS\AdminConfig\Listeners\ServerGroup\ClearUsersReservedCache;
use SquadMS\Foundation\Contracts\SquadMSModuleServiceProvider;
use SquadMS\Foundation\Facades\SquadMSPermissions;

class AdminConfigServiceProvider extends SquadMSModuleServiceProvider
{
    public static string $name = 'sqms-adminconfig';

    protected array $resources = [
        AdminConfigResource::class,
        ServerGroupResource::class,
        ServerPermissionResource::class,
    ];

    protected $listen = [
        AdminConfigSaving::class => [
            ClearUsersMainGroupCache::class,
        ],
        ServerGroupRemovedPermission::class => [
            ClearUsersReservedCache::class,
        ],
    ];

    public function configureModule(Package $package): void
    {
        $package->hasAssets()
                ->hasConfigFile()
                ->hasRoutes(['api']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function registeringModule(): void
    {
        
    }

    public function bootedModule(): void
    {
        /* Validates a HEX color code (like from color inputs) */
        Validator::extend('color', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^#[a-f0-9]{6}$/i', $value) === 1;
        });

        /* Permissions */
        foreach (Config::get('sqms-adminconfig.permissions.definitions', []) as $definition => $displayName) {
            SquadMSPermissions::define(Config::get('sqms-adminconfig.permissions.module'), $definition, $displayName);
        }
    }
}

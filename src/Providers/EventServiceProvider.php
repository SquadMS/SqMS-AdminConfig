<?php

namespace SquadMS\AdminConfig\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SquadMS\AdminConfig\Events\Internal\AdminConfig\AdminConfigSaving;
use SquadMS\AdminConfig\Events\Internal\ServerGroup\ServerGroupRemovedPermission;
use SquadMS\AdminConfig\Listeners\AdminConfig\ClearUsersMainGroupCache;
use SquadMS\AdminConfig\Listeners\ServerGroup\ClearUsersReservedCache;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AdminConfigSaving::class => [
            ClearUsersMainGroupCache::class,
        ],
        ServerGroupRemovedPermission::class => [
            ClearUsersReservedCache::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
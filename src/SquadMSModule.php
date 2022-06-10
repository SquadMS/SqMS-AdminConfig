<?php

namespace SquadMS\AdminConfig;

use Illuminate\Console\Scheduling\Schedule;
use SquadMS\Foundation\Facades\SquadMSAdminMenu;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule as SquadMSModuleContract;


class SquadMSModule extends SquadMSModuleContract
{
    public static function getIdentifier(): string
    {
        return 'sqms-adminconfig';
    }

    public static function getName(): string
    {
        return 'SquadMS Admin Config';
    }

    public static function publishAssets(): void
    {
        //
    }

    public static function registerAdminMenus(): void
    {
        SquadMSAdminMenu::register('admin-adminconfig', 300);
    }

    public static function registerMenuEntries(string $menu): void
    {
        switch ($menu) {
            case 'admin-adminconfig':
                /* Admin Menu */
                //

                break;
        }
    }

    public static function schedule(Schedule $schedule): void
    {
        //
    }
}

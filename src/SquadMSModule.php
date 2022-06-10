<?php

namespace SquadMS\AdminConfig;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use SquadMS\Foundation\Facades\SquadMSAdminMenu;
use SquadMS\Foundation\Facades\SquadMSMenu;
use SquadMS\Foundation\Helpers\NavigationHelper;
use SquadMS\Foundation\Menu\SquadMSMenuEntry;
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
                SquadMSMenu::prepend('admin-adminconfig', fn () => View::make('sqms-foundation::components.navigation.heading', [
                    'title'  => 'AdminConfig Management',
                ])->render());

                SquadMSMenu::register(
                    'admin-adminconfig',
                    (new SquadMSMenuEntry('admin.permissions.index', '<i class="bi bi-house-fill"></i> Permissions', true))->setView('sqms-foundation::components.navigation.item')
                    ->setActive(fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute('admin.permissions.*'))
                    ->setCondition('sqms admin adminconfig manage')
                    ->setOrder(200)
                );

                SquadMSMenu::register(
                    'admin-adminconfig',
                    (new SquadMSMenuEntry('admin.permissions.index', '<i class="bi bi-house-fill"></i> Groups', true))->setView('sqms-foundation::components.navigation.item')
                    ->setActive(fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute('admin.groups.*'))
                    ->setCondition('sqms admin adminconfig manage')
                    ->setOrder(200)
                );

                SquadMSMenu::register(
                    'admin-adminconfig',
                    (new SquadMSMenuEntry('admin.adminconfigs.index', '<i class="bi bi-house-fill"></i> AdminConfigs', true))->setView('sqms-foundation::components.navigation.item')
                    ->setActive(fn (SquadMSMenuEntry $link) => NavigationHelper::isCurrentRoute('admin.groups.*'))
                    ->setCondition('sqms admin adminconfig manage')
                    ->setOrder(200)
                );

                break;
        }
    }

    public static function schedule(Schedule $schedule): void
    {
        //
    }
}

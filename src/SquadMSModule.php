<?php

namespace SquadMS\AdminConfig;

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
}

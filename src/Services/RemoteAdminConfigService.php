<?php

namespace SquadMS\AdminConfig\Services;

use SquadMS\AdminConfig\Models\AdminConfig;

class RemoteAdminConfigService
{
    /**
     * Get the admin config
     *
     * @return string
     */
    public static function generate(AdminConfig $adminConfig): string
    {
        $output = '# Groups'.PHP_EOL;
        foreach ($adminConfig->serverGroups->unique('id') as $group) {
            /* Skip groups without rights */
            if ($group->permissions->count() == 0) {
                continue;
            }

            /* Format permissions string */
            $permissions = $group->permissions->pluck('config_key')->toArray();

            /* Add group to the output */
            $output .= 'Group='.$group->name.':'.implode(',', $permissions).PHP_EOL;
        }
        $output .= PHP_EOL.PHP_EOL;

        $entries = $adminConfig->entries()->get()->sortBy('serverGroup.id');

        $output .= '# Users'.PHP_EOL;
        foreach ($entries as $entry) {
            /* Skip groups without rights */
            if (! $entry->serverGroup->permissions->count()) {
                continue;
            }

            $output .= 'Admin='.$entry->user->steam_id_64.':'.$entry->serverGroup->name.' // '.$entry->user->name.($entry->user->clan ? ' ('.$entry->user->clan->tag.')' : '').PHP_EOL;
        }

        return $output;
    }
}

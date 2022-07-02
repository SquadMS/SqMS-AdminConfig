<?php

namespace SquadMS\AdminConfig\Listeners\ServerGroup;

use SquadMS\AdminConfig\Events\Internal\ServerGroup\Abstracts\ServerGroupChangedPermission;

class ClearUsersReservedCache
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ServerGroupChangedPermission $event)
    {
        /* Check that the reserved permission has changed */
        if ($event->permission->config_key === 'reserve') {
            /** @var \App\User $user */
            foreach ($event->group->users as $user) {
                $user->clearReservedCache();
            }
        }
    }
}

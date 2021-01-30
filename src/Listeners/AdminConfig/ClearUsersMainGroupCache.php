<?php

namespace SquadMS\AdminConfig\Listeners\AdminConfig;

use SquadMS\AdminConfig\Events\Internal\AdminConfig\AdminConfigSaving;

class ClearUsersMainGroupCache
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AdminConfigSaving $event)
    {
        /* Make sure the main attribute changed */
        if ($event->adminConfig->getOriginal('main') !== $event->adminConfig->main) {
            /** @var \App\User $user */
            foreach ($event->adminConfig->users as $user) {
                $user->clearMainGroupCache();
            }
        }
    }
}
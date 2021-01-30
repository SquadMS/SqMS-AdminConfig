<?php

namespace SquadMS\AdminConfig\Events\Internal\ServerGroup\Abstracts;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SquadMS\AdminConfig\Models\ServerGroup;
use SquadMS\AdminConfig\Models\ServerPermission;

abstract class ServerGroupChangedPermission
{
    use Dispatchable, SerializesModels;

    public ServerGroup $group;
    public ServerPermission $permission;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ServerGroup $group, ServerPermission $permission)
    {
        $this->group = $group;
        $this->permission = $permission;
    }
}
<?php

namespace SquadMS\AdminConfig\Events\Internal\AdminConfig;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SquadMS\AdminConfig\Models\AdminConfig;

class AdminConfigSaving
{
    use Dispatchable, SerializesModels;

    public AdminConfig $adminConfig;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminConfig $adminConfig)
    {
        $this->adminConfig = $adminConfig;
    }
}

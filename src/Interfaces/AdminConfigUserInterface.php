<?php

namespace SquadMS\AdminConfig\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SquadMS\AdminConfig\Models\ServerGroup;

interface AdminConfigUserInterface
{
    public function adminConfigs() : BelongsToMany;

    public function adminConfigEntries() : HasMany;

    public function getMainGroupAttribute() : ?ServerGroup;

    public function clearMainGroupCache() : void;

    public function getReservedAttribute() : bool;

    public function clearReservedCache() : void;
}
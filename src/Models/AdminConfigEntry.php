<?php

namespace SquadMS\AdminConfig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminConfigEntry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'admin_config_id',
        'server_group_id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'user',
        'adminConfig',
        'serverGroup',
    ];

    /**
     * Get the members associated with the clan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Get the members associated with the clan.
     */
    public function adminConfig(): BelongsTo
    {
        return $this->belongsTo(AdminConfig::class);
    }

    /**
     * Get the members associated with the clan.
     */
    public function serverGroup(): BelongsTo
    {
        return $this->belongsTo(ServerGroup::class);
    }
}

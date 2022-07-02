<?php

namespace SquadMS\AdminConfig\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use SquadMS\AdminConfig\Models\AdminConfig;
use SquadMS\AdminConfig\Models\AdminConfigEntry;
use SquadMS\AdminConfig\Models\ServerGroup;

trait AdminConfigUserTrait
{
    /**
     * Get the AdminConfigs associated with the user.
     *
     * @return BelongsToMany
     */
    public function adminConfigs(): BelongsToMany
    {
        return $this->belongsToMany(AdminConfig::class, 'admin_config_entries');
    }

    /**
     * Get the AdminConfigs associated with the user.
     *
     * @return BelongsToMany
     */
    public function adminConfigEntries(): HasMany
    {
        return $this->hasMany(AdminConfigEntry::class);
    }

    public function getMainGroupAttribute(): ?ServerGroup
    {
        return Cache::tags(['user-main-group', 'user-'.$this->id])->rememberForever('user-main-group-'.$this->id, function () {
            /** @var null|ServerGroup */
            $group = null;

            foreach ($this->adminConfigEntries()->get()->where('adminConfig.main', true)->unique('serverGroup.id') as $entry) {
                if (! $group || ! $group->importance < $entry->serverGroup->importance) {
                    $group = $entry->serverGroup;
                }
            }

            return $group ?? false;
        }) ?: null;
    }

    public function clearMainGroupCache(): void
    {
        Cache::tags(['user-main-group', 'user-'.$this->id])->forget('user-main-group-'.$this->id);
    }

    /**
     * Determines if the User is member of a group
     * that has the reserved permission.
     *
     * @return bool
     */
    public function getReservedAttribute(): bool
    {
        $var = Cache::tags(['user-reserved', 'user-'.$this->id])->rememberForever('user-reserved-'.$this->id, function () {
            foreach ($this->adminConfigEntries()->get()->where('adminConfig.main', true)->unique('serverGroups.id') as $entry) {
                if ($entry->serverGroup->hasPermission('reserve')) {
                    return true;
                }
            }

            return false;
        });

        return $var;
    }

    public function clearReservedCache(): void
    {
        Cache::tags(['user-reserved', 'user-'.$this->id])->forget('user-reserved-'.$this->id);
    }
}

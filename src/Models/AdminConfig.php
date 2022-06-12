<?php

namespace SquadMS\AdminConfig\Models;

use SquadMS\AdminConfig\Events\Internal\AdminConfig\AdminConfigSaving;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use SquadMS\Foundation\Models\SquadMSUser;

class AdminConfig extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'reserved_group_id',
        'main',
    ];

    /**
     * The event map for the model.
     */
    protected $dispatchesEvents = [
        'saving' => AdminConfigSaving::class,
    ];

    /**
     * Get the server group used for reserved slots.
     */
    public function entries() : HasMany
    {
        return $this->hasMany(AdminConfigEntry::class);
    }

    /**
     * Get the server group used for reserved slots.
     */
    public function reservedGroup() : BelongsTo
    {
        return $this->belongsTo(ServerGroup::class, 'reserved_group_id');
    }

    /**
     * Get the server groups assigned to this admin config.
     */
    public function serverGroups() : BelongsToMany
    {
        return $this->belongsToMany(ServerGroup::class, 'admin_config_entries');
    }

    /**
     * Get the server groups assigned to this admin config.
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(SquadMSUser::class, 'admin_config_entries');
    }

    public function addUser(Model $user, ServerGroup $group) : void
    {
        $this->checkUserModel($user);

        $this->entries()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'user_id' => $user->id,
            'server_group_id' => $group->id,
        ]);

        if ($this->main) {
            $user->clearMainGroupCache();
        }

        /* Forget the users reserved cache */
        $user->clearReservedCache();
    }

    /**
     * Determines if the given user has a group in this admin config.
     *
     * @param User $user
     */
    public function hasUser(SquadMSUser $user) : bool
    {
        return $this->users->contains(function ($item, $key) use ($user) {
            return $item->id === $user->id;
        });
    }

    public function duplicate() : ?AdminConfig
    {       
        try {
            DB::beginTransaction();

            /** @var AdminConfig|null */
            $duplicate = AdminConfig::create([
                'name' => $this->name . ' (Copy)',
                'reserved_group_id' => $this->reservedGroup->id,
                'main' => $this->main,
            ]);

            foreach ($this->entries as $entry) {
                $duplicate->entries()->create([
                    'user_id' => $entry->user_id,
                    'server_group_id' => $entry->server_group_id,
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        return $duplicate;     
    }

    private function checkUserModel(Model $user) : void
    {
        if (get_class($user) !== config('auth.providers.users.model')) {
            throw new InvalidArgumentException('$user must be of type ' . config('auth.providers.users.model'));
        }
    }
}
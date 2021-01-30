<?php

namespace SquadMS\AdminConfig\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;

/**
 * App\Group
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $permissions_count
 * @property-read int|null $users_count
 */
class ServerGroup extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
        'importance',
    ];

    /**
     * Get all of the posts for the country.
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(ServerPermission::class, ServerGroupServerPermission::class);
    }

    public function hasPermission(string $key) : bool {
        foreach ($this->permissions as $permission) {
            if ($permission->config_key === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the users for the group.
     */
    public function users() : HasManyThrough
    {
        return $this->hasManyThrough(
            config('auth.providers.users.model'),
            AdminConfigEntry::class,
            'server_group_id',
            'id',
            'id',
            'user_id'
        );
    }
}

<?php

namespace SquadMS\AdminConfig\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GroupPermission
 *
 * @property int $id
 * @property int $server_group_id
 * @property int $server_permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GroupPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServerGroupServerPermission whereServerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServerGroupServerPermission whereServerPermissionId($value)
 */
class ServerGroupServerPermission extends Model
{
    //
}

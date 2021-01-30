<?php

namespace SquadMS\AdminConfig\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use SquadMS\AdminConfig\Models\ServerGroup;
use SquadMS\AdminConfig\Models\ServerPermission;
use SquadMS\AdminConfig\Events\Internal\ServerGroup\ServerGroupAddedPermission;
use SquadMS\AdminConfig\Events\Internal\ServerGroup\ServerGroupRemovedPermission;
use SquadMS\AdminConfig\Http\Requests\Groups\StoreGroup;
use SquadMS\AdminConfig\Http\Requests\Groups\UpdateGroup;
use SquadMS\AdminConfig\Http\Requests\Groups\DeleteGroup;
use SquadMS\AdminConfig\Http\Requests\Groups\GroupAddPermission;
use SquadMS\AdminConfig\Http\Requests\Groups\GroupRemovePermission;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.groups.index', [
            'groups' => ServerGroup::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroup $request)
    {
        /* Get validated data */
        $data = $request->validated();

        /* Create group */
        $group = ServerGroup::create($data);

        /* Redirect to edit page */
        return redirect(route('admin.groups.edit', [
            'group' => $group
        ]))->withSuccess('Server Gruppe erfolgreich erstellt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \SquadMS\AdminConfig\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(ServerGroup $group)
    {
        return view('admin.groups.show', [
            'group' => $group
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SquadMS\AdminConfig\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(ServerGroup $group)
    {
        /* Fetch available permissions */
        $ownedPermissions = $group->permissions->pluck('id')->toArray();
        $permissions = ServerPermission::whereNotIn('id', $ownedPermissions)->get();

        /* Return view */
        return view('admin.groups.edit', [
            'group' => $group,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SquadMS\AdminConfig\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroup $request, ServerGroup $group)
    {
        /* Get validated data */
        $data = $request->validated();

        /* Update group */
        $group->update($data);

        /* Redirect to index page */
        return redirect(route('admin.groups.index'))->withSuccess('Server Gruppe erfolgreich bearbeitet.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SquadMS\AdminConfig\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteGroup $request, ServerGroup $group)
    {
        /* Remove the group */
        $group->delete();

        /* Redirect to index */
        return redirect(route('admin.groups.index'))->withSuccess('Server Gruppe erfolgreich gelöscht.');
    }

    /**
     * Remove the specified permission to the group.
     *
     * @param  \SquadMS\AdminConfig\Http\Requests\DeleteClan  $request
     * @param  \SquadMS\AdminConfig\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function addPermission(GroupAddPermission $request, ServerGroup $group)
    {
        /* Get validated data */
        $data = $request->validated();
        $permission = ServerPermission::find(intval($data['permission_id']));

        if ($group->hasPermission($permission->config_key)) {
            return redirect()->back()->withErrors('Das Recht wurde der Gruppe bereits hinzugefügt.');
        }
        
        /* Add to group */
        $group->permissions()->attach($permission);

        event(new ServerGroupAddedPermission($group, $permission));

        /* Redirect back to clans list */
        return redirect(route('admin.groups.edit', [
            'group' => $group
        ]))->withSuccess('Recht erfolgreich zu Server Gruppe hinzugefügt.');
    }

    /**
     * Remove the specified permission from the group.
     *
     * @param  \SquadMS\AdminConfig\Http\Requests\DeleteClan  $request
     * @param  \SquadMS\AdminConfig\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function removePermission(GroupRemovePermission $request, ServerGroup $group)
    {
        /* Get validated data */
        $permission = ServerPermission::find($request->route('permission'));

        /* Remove from group */
        $group->permissions()->detach($permission);

        event(new ServerGroupRemovedPermission($group, $permission));

        /* Redirect back to clans list */
        return redirect(route('admin.groups.edit', [
            'group' => $group
        ]))->withSuccess('Recht erfolgreich von Server Gruppe entfernt.');
    }
}

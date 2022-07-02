<?php

namespace SquadMS\AdminConfig\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use SquadMS\AdminConfig\Http\Requests\Permissions\DeletePermission;
use SquadMS\AdminConfig\Http\Requests\Permissions\StorePermission;
use SquadMS\AdminConfig\Http\Requests\Permissions\UpdatePermission;
use SquadMS\AdminConfig\Models\ServerPermission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.permissions.index', [
            'permissions' => ServerPermission::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermission $request)
    {
        /* Get validated data */
        $data = $request->validated();

        /* Create permission */
        $permission = ServerPermission::create($data);

        /* Redirect to edit page */
        return redirect(route('admin.permissions.index'))->withSuccess('Recht erfolgreich erstellt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \SquadMS\AdminConfig\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(ServerPermission $permission)
    {
        return view('admin.permissions.show', [
            'permission' => $permission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SquadMS\AdminConfig\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(ServerPermission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SquadMS\AdminConfig\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermission $request, ServerPermission $permission)
    {
        /* Get validated data */
        $data = $request->validated();

        /* Update permission */
        $permission->update($data);

        /* Redirect to index page */
        return redirect(route('admin.permissions.index'))->withSuccess('Recht erfolgreich bearbeitet.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SquadMS\AdminConfig\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeletePermission $request, ServerPermission $permission)
    {
        /* Remove the permission */
        $permission->delete();

        /* Redirect to index */
        return redirect(route('admin.permissions.index'))->withSuccess('Recht erfolgreich gelöscht.');
    }
}

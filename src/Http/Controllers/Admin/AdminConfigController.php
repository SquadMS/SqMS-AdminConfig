<?php

namespace SquadMS\AdminConfig\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use SquadMS\AdminConfig\Http\Requests\AdminConfig\AdminConfigAddMember;
use SquadMS\AdminConfig\Http\Requests\AdminConfig\AdminConfigRemoveMember;
use SquadMS\AdminConfig\Http\Requests\AdminConfig\DeleteAdminConfig;
use SquadMS\AdminConfig\Http\Requests\AdminConfig\DuplicateAdminConfig;
use SquadMS\AdminConfig\Http\Requests\AdminConfig\StoreAdminConfig;
use SquadMS\AdminConfig\Http\Requests\AdminConfig\UpdateAdminConfig;
use SquadMS\AdminConfig\Models\AdminConfig;
use SquadMS\AdminConfig\Models\AdminConfigEntry;
use SquadMS\AdminConfig\Models\ServerGroup;
use Yajra\DataTables\Facades\DataTables;

class AdminConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.adminconfigs.index', [
            'adminConfigs' => AdminConfig::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adminconfigs.create', [
            'availableGroups' => ServerGroup::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAdminConfig  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminConfig $request)
    {
        /* Create group */
        $adminConfig = AdminConfig::create($request->validated());

        /* Redirect to edit page */
        return redirect()->route('admin.adminconfigs.edit', $adminConfig)->withSuccess('Admin Config erfolgreich erstellt.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SquadMS\AdminConfig\AdminConfig  $adminConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminConfig $adminconfig)
    {
        /* Return view */
        return view('admin.adminconfigs.edit', [
            'adminConfig' => $adminconfig,
            'availableGroups' => ServerGroup::all(),
        ]);
    }

    public function entries(Request $request, AdminConfig $adminconfig)
    {
        /** @var \SquadMS\AdminConfig\User */
        if (($user = Auth::user()) && $user->can('admin servergroups')) {
            return DataTables::eloquent($adminconfig->entries()->select('admin_config_entries.*')->with('user', 'serverGroup'))
                ->addColumn('image', function (AdminConfigEntry $entry) {
                    return view('admin.adminconfigs.parts.image', [
                        'user' => $entry->user,
                    ])->render();
                })
                ->addColumn('name', function (AdminConfigEntry $entry) {
                    return view('admin.adminconfigs.parts.name', [
                        'user' => $entry->user,
                    ])->render();
                })
                ->addColumn('group', function (AdminConfigEntry $entry) {
                    return $entry->serverGroup->name;
                })
                ->addColumn('actions', function (AdminConfigEntry $entry) use ($adminconfig) {
                    return view('admin.adminconfigs.parts.actions', [
                        'adminConfig' => $adminconfig,
                        'entry' => $entry,
                    ])->render();
                })
                ->rawColumns(['image', 'name', 'actions'])
                ->make();
        } else {
            return response()->json([
                'status' => false,
                'error' => 'No permission.',
            ]);
        }
    }

    public function possibleUsers(Request $request, AdminConfig $adminconfig)
    {
        /** @var \SquadMS\AdminConfig\User */
        if (($user = Auth::user()) && $user->can('admin servergroups')) {
            $users = $this->getUserModel()->whereNotIn('id', $adminconfig->users->pluck('id'))->where(function ($query) use ($request) {
                return $query->where('name', 'like', $request->input('q'))
                ->orWhere('name', 'like', '%'.$request->input('q'))
                ->orWhere('name', 'like', $request->input('q').'%')
                ->orWhere('name', 'like', '%'.$request->input('q').'%');
            })->get();

            return response()->json([
                'status' => true,
                'users' => $users,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'No permission.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SquadMS\AdminConfig\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminConfig $request, AdminConfig $adminconfig)
    {
        /* Update group */
        $adminconfig->update($request->validated());

        /* Redirect to index page */
        return redirect()->back()->withSuccess('Admin Config erfolgreich geändert.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DuplicateAdminConfig  $request
     * @param  AdminConfig  $adminconfig
     * @return \Illuminate\Http\Response
     */
    public function duplicate(DuplicateAdminConfig $request, AdminConfig $adminconfig)
    {
        /* Duplicate it */
        $newAdminConfig = $adminconfig->duplicate();

        /* Redirect to index page */
        return redirect()->route('admin.adminconfigs.edit', $newAdminConfig)->withSuccess('Admin Config erfolgreich geändert.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteAdminConfig  $request
     * @param  AdminConfig  $adminconfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteAdminConfig $request, AdminConfig $adminconfig)
    {
        /* Remove the group */
        $adminconfig->delete();

        /* Redirect to index */
        return redirect()->back()->withSuccess('Admin Config erfolgreich gelöscht.');
    }

    /**
     * Add the specified user to the group.
     *
     * @param  \SquadMS\AdminConfig\Http\Requests\DeleteClan  $request
     * @param  \SquadMS\AdminConfig\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function addEntry(AdminConfigAddMember $request, AdminConfig $adminconfig)
    {
        $user = $this->getUserModel()->findOrFail($request->validated()['user_id']);
        $serverGroup = ServerGroup::findOrFail($request->validated()['server_group_id']);

        if ($adminconfig->hasUser($user)) {
            return redirect()->back()->withErrors('Benutzer ist bereits in der Admin Config eingetragen.');
        } else {
            $adminconfig->addUser($user, $serverGroup);
        }

        /* Redirect back to clans list */
        return redirect()->back()->withSuccess('Eintrag wurde der Admin Config hinzugefügt.');
    }

    /**
     * Remove the specified user from the group.
     *
     * @param  \SquadMS\AdminConfig\Http\Requests\DeleteClan  $request
     * @param  \SquadMS\AdminConfig\Clan  $clan
     * @return \Illuminate\Http\Response
     */
    public function removeEntry(AdminConfigRemoveMember $request, AdminConfig $adminconfig, AdminConfigEntry $entry)
    {
        /* Invalidate the main group cache if its a main group */
        if ($adminconfig->main) {
            $entry->user->clearMainGroupCache();
        }

        /* Forget the users reserved cache */
        $entry->user->clearReservedCache();

        /* Remove the entry */
        $entry->delete();

        /* Redirect back to clans list */
        return redirect()->back()->withSuccess('Eintrag aus Admin Config entfernt.');
    }

    /**
     * Get the User model instance
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected static function getUserModel(): Model
    {
        $model = config('auth.providers.users.model');

        return new $model();
    }
}

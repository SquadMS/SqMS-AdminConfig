<?php

namespace SquadMS\AdminConfig\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use SquadMS\AdminConfig\Models\AdminConfig;
use SquadMS\AdminConfig\Services\RemoteAdminConfigService;

class ConfigController extends Controller
{
    /**
     * Shows the remote admin config
     *
     * @return \Illuminate\Http\Response
     */
    public function remoteAdmin(Request $request, AdminConfig $adminconfig)
    {
        return response(RemoteAdminConfigService::generate($adminconfig), 200, [
            'Content-type'        => 'text/plain',
            //'Content-Disposition' => 'attachment; filename="admin.cfg"',
        ]);
    }
}
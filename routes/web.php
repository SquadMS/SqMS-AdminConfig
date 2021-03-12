<?php

use Illuminate\Support\Facades\Route;
use SquadMS\AdminConfig\Http\Controllers\Admin\AdminConfigController;
use SquadMS\AdminConfig\Http\Controllers\Admin\GroupController;
use SquadMS\AdminConfig\Http\Controllers\Admin\PermissionController;
use SquadMS\AdminConfig\Http\Controllers\ConfigController;

/* Remote admin config */
Route::get('admin-cfg/{adminconfig}', [ConfigController::class, 'remoteAdmin'])->name('remoteAdmin');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin', 'noIndex']
], function(){
    /* Permissions */
    Route::resource('permissions', PermissionController::class);

    /* Groups */
    Route::post('groups/{group}/permissions', [GroupController::class, 'addPermission'])->name('groups.permissions.add');
    Route::delete('groups/{group}/permissions/{permission}', [GroupController::class, 'removePermission'])->name('groups.permissions.remove');
    Route::post('groups/{group}/members', [GroupController::class, 'addUser'])->name('groups.members.add');
    Route::delete('groups/{group}/members/{user}', [GroupController::class, 'removeUser'])->name('groups.members.remove');
    Route::resource('groups', GroupController::class);

    /* AdminConfigs */
    Route::get('adminconfigs/{adminconfig}/entries', [AdminConfigController::class, 'entries'])->name('adminconfigs.entries');
    Route::post('adminconfigs/{adminconfig}/entries', [AdminConfigController::class, 'addEntry'])->name('adminconfigs.entries.add');
    Route::delete('adminconfigs/{adminconfig}/entries/{entry}', [AdminConfigController::class, 'removeEntry'])->name('adminconfigs.entries.remove');
    Route::post('adminconfigs/{adminconfig}/duplicate', [AdminConfigController::class, 'duplicate'])->name('adminconfigs.duplicate');
    Route::get('adminconfigs/{adminconfig}/possibleUsers', [AdminConfigController::class, 'possibleUsers'])->name('adminconfigs.possibleUsers');
    Route::resource('adminconfigs', AdminConfigController::class)->except([
        'show',
    ]);
});
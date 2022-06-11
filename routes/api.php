<?php

use Illuminate\Support\Facades\Route;
use SquadMS\AdminConfig\Http\Controllers\API\AdminConfigController;

/* Remote admin config */
Route::get('admin-cfg/{adminconfig}', [AdminConfigController::class, 'remoteAdmin'])->name('remoteAdmin');
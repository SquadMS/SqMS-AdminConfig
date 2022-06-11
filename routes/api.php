<?php

use Illuminate\Support\Facades\Route;
use SquadMS\AdminConfig\Http\Controllers\ConfigController;

/* Remote admin config */
Route::get('admin-cfg/{adminconfig}', [ConfigController::class, 'remoteAdmin'])->name('remoteAdmin');
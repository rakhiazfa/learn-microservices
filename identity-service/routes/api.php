<?php

use App\Http\Controllers\AccessRightController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/* --------------------------------------------------------------------------------------
| Auth
-------------------------------------------------------------------------------------- */

Route::prefix('/auth')->middleware('authentication')->group(function () {
    Route::post('/signin', [AuthController::class, 'signIn'])->withoutMiddleware('authentication');
    Route::post('/signout', [AuthController::class, 'signOut']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::middleware('authentication')->group(function () {

    /* --------------------------------------------------------------------------------------
    | Identities
    -------------------------------------------------------------------------------------- */

    Route::apiResource('/identities', IdentityController::class, [
        'parameters' => ['identities' => 'id'],
    ]);

    /* --------------------------------------------------------------------------------------
    | Roles
    -------------------------------------------------------------------------------------- */

    Route::get('/roles/search', [RoleController::class, 'search']);

    Route::apiResource('/roles', RoleController::class, [
        'parameters' => ['roles' => 'id'],
    ]);

    /* --------------------------------------------------------------------------------------
    | Access Rights
    -------------------------------------------------------------------------------------- */

    Route::get('/access-rights/search', [AccessRightController::class, 'search']);

    Route::apiResource('/access-rights', AccessRightController::class, [
        'parameters' => ['access-rights' => 'id'],
    ]);
});

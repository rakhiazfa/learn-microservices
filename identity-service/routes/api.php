<?php

use App\Http\Controllers\AccessRightController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('authentication')->group(function () {

    /* --------------------------------------------------------------------------------------
    | Auth
    -------------------------------------------------------------------------------------- */

    Route::prefix('/auth')->group(function () {
        Route::post('/signin', [AuthController::class, 'signIn'])->withoutMiddleware('authentication');
        Route::post('/signout', [AuthController::class, 'signOut']);
        Route::get('/user', [AuthController::class, 'user']);
    });

    /* --------------------------------------------------------------------------------------
    | Identities
    -------------------------------------------------------------------------------------- */

    Route::apiResource('/identities', IdentityController::class, [
        'parameters' => ['identities' => 'id'],
    ]);

    Route::post('/identities/{id}/roles', [IdentityController::class, 'assignRoles']);

    /* --------------------------------------------------------------------------------------
    | Roles
    -------------------------------------------------------------------------------------- */

    Route::get('/roles/search', [RoleController::class, 'search']);

    Route::apiResource('/roles', RoleController::class, [
        'parameters' => ['roles' => 'id'],
    ]);

    Route::post('/roles/{id}/access-rights', [RoleController::class, 'assignAccessRights']);

    /* --------------------------------------------------------------------------------------
    | Access Rights
    -------------------------------------------------------------------------------------- */

    Route::get('/access-rights/search', [AccessRightController::class, 'search']);

    Route::apiResource('/access-rights', AccessRightController::class, [
        'parameters' => ['access-rights' => 'id'],
    ]);
});

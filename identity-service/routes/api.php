<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdentityController;
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

    Route::apiResource('/roles', IdentityController::class, [
        'parameters' => ['roles' => 'id'],
    ]);
});

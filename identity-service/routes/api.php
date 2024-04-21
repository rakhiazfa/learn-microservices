<?php

use App\Http\Controllers\IdentityController;
use Illuminate\Support\Facades\Route;

Route::get('/identities/search', [IdentityController::class, 'search']);
Route::apiResource('/identities', IdentityController::class, [
    'parameters' => ['identities' => 'id'],
]);

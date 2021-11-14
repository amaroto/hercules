<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('users', [UserController::class, 'index']);

    Route::get('profile', [UserController::class, 'profile']);

    Route::prefix('user')->group(function () {
        Route::get('{id}', [UserController::class, 'find']);
        Route::delete('{id}', [UserController::class, 'delete']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::post('', [UserController::class, 'create']);
    });

    // Route::apiResource('users', UserController::class)->only(['show']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ClientController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    // START USERS

    Route::get('users', [UserController::class, 'index']);

    Route::get('users/pdf', [UserController::class, 'exportPdf']);

    Route::get('profile', [UserController::class, 'profile']);

    Route::prefix('user')->group(function () {
        Route::get('{id}', [UserController::class, 'find']);
        Route::delete('{id}', [UserController::class, 'delete']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::post('', [UserController::class, 'create']);
    });

    // END USERS

    // START LEADS

    Route::get('leads', [LeadController::class, 'index']);

    Route::get('leads/pdf', [LeadController::class, 'exportPdf']);

    Route::prefix('lead')->group(function () {
        Route::get('{id}', [LeadController::class, 'find']);
        Route::delete('{id}', [LeadController::class, 'delete']);
        Route::put('{id}', [LeadController::class, 'update']);
        Route::post('', [LeadController::class, 'create']);
    });

    // END LEADS

    // START LEADS

    Route::get('clients', [ClientController::class, 'index']);

    Route::get('clients/pdf', [ClientController::class, 'exportPdf']);

    Route::prefix('client')->group(function () {
        Route::get('{id}', [ClientController::class, 'find']);
        Route::delete('{id}', [ClientController::class, 'delete']);
        Route::put('{id}', [ClientController::class, 'update']);
        Route::post('', [ClientController::class, 'create']);
    });

    // END LEADS

});

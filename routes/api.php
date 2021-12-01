<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UnauthorizedController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;

Route::get('unauthorized', [UnauthorizedController::class, 'index'])->name('unauthorized');

Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    // START USERS

    Route::get('users', [UserController::class, 'index'])->middleware('abilities:users-search');

    Route::get('users/pdf', [UserController::class, 'exportPdf'])->middleware('abilities:users-export-pdf');

    Route::get('profile', [UserController::class, 'profile'])->middleware('abilities:users-profile');

    Route::prefix('user')->group(function () {
        Route::get('{id}', [UserController::class, 'find'])->middleware('abilities:users-find');
        Route::delete('{id}', [UserController::class, 'delete'])->middleware('abilities:users-delete');
        Route::put('{id}', [UserController::class, 'update'])->middleware('abilities:users-update');
        Route::post('', [UserController::class, 'create'])->middleware('abilities:users-create');
    });

    // END USERS

    // START LEADS

    Route::get('leads', [LeadController::class, 'index'])->middleware('abilities:leads-search');

    Route::get('leads/pdf', [LeadController::class, 'exportPdf'])->middleware('abilities:leads-export-pdf');

    Route::prefix('lead')->group(function () {
        Route::get('{id}', [LeadController::class, 'find'])->middleware('abilities:leads-find');
        Route::delete('{id}', [LeadController::class, 'delete'])->middleware('abilities:leads-delete');
        Route::put('{id}', [LeadController::class, 'update'])->middleware('abilities:leads-update');
        Route::post('', [LeadController::class, 'create'])->middleware('abilities:leads-create');
    });

    // END LEADS

    // START CLIENTS

    Route::get('clients', [ClientController::class, 'index'])->middleware('abilities:clients-search');

    Route::get('clients/pdf', [ClientController::class, 'exportPdf'])->middleware('abilities:clients-export-pdf');

    Route::prefix('client')->group(function () {
        Route::get('{id}', [ClientController::class, 'find'])->middleware('abilities:clients-find');
        Route::delete('{id}', [ClientController::class, 'delete'])->middleware('abilities:clients-delete');
        Route::put('{id}', [ClientController::class, 'update'])->middleware('abilities:clients-update');
        Route::post('', [ClientController::class, 'create'])->middleware('abilities:clients-create');
    });

    // END CLIENTS

    // START COMPANIES

    Route::get('companies', [CompanyController::class, 'index'])->middleware('abilities:companies-search');

    Route::get('companies/pdf', [CompanyController::class, 'exportPdf'])->middleware('abilities:companies-search');

    Route::prefix('company')->group(function () {
        Route::get('{id}', [CompanyController::class, 'find'])->middleware('abilities:companies-find');
        Route::delete('{id}', [CompanyController::class, 'delete'])->middleware('abilities:companies-delete');
        Route::put('{id}', [CompanyController::class, 'update'])->middleware('abilities:companies-update');
        Route::post('', [CompanyController::class, 'create'])->middleware('abilities:companies-create');
    });

    // END COMPANIES

});

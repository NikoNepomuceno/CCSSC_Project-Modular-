<?php

use App\Modules\Admin\Http\Controllers\AuthController;
use App\Modules\Admin\Http\Controllers\DashboardController;
use App\Modules\Admin\Http\Controllers\OrganizationUserController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('admin.slug'))
    ->middleware('web')
    ->group(function () {
        // Guest routes (not logged in)
        Route::middleware('guest:admin')->group(function () {
            Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
            Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
        });

        // Authenticated routes
        Route::middleware('auth:admin')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

            // Session management
            Route::get('/sessions', [AuthController::class, 'sessions'])->name('admin.sessions');
            Route::post('/sessions/revoke-others', [AuthController::class, 'revokeOtherSessions'])->name('admin.sessions.revoke-others');
            Route::delete('/sessions/{sessionId}', [AuthController::class, 'revokeSession'])->name('admin.sessions.revoke');

            // Organization users management
            Route::resource('organization-users', OrganizationUserController::class)
                ->except(['show'])
                ->names('admin.organization-users');
        });
    });

// API routes for admin authentication (stateless)
Route::prefix('api/admin')
    ->middleware('throttle:10,1')
    ->group(function () {
        Route::post('/login', [AuthController::class, 'apiLogin'])->name('admin.api.login');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('admin.api.refresh');
    });


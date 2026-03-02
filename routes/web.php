<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserDownloadController;
use App\Http\Controllers\UserLocationController;
use App\Http\Controllers\Admin;

// Landing page - no redirect
Route::get('/', function () {
    return view('welcome');
})->name('home');

// COTS Sightings page
Route::get('/sightings', [LocationController::class, 'sightings'])->name('sightings');

// Public download page
Route::get('/download', [DownloadController::class, 'index'])->name('download');

// Authentication routes
Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'customLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'signOut'])->name('logout');

// Google OAuth routes
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

// API routes for offline sync
Route::middleware('auth')->group(function () {
    Route::post('/api/sync-locations', [UserLocationController::class, 'syncLocations'])->name('api.sync-locations');
});

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin')
    ->group(function () {
        // Dashboard
        Route::get('/',              [Admin\DashboardController::class, 'index'])->name('index');
        Route::get('/dashboard-data',[Admin\DashboardController::class, 'dashboardData'])->name('dashboard.data');

        // Locations
        Route::get('/locations',         [Admin\LocationController::class, 'index'])->name('location');
        Route::post('/locations',         [Admin\LocationController::class, 'store'])->name('locations.store');
        Route::delete('/locations/{id}',  [Admin\LocationController::class, 'destroy'])->name('locations.destroy');
        Route::get('/report',            [Admin\LocationController::class, 'report'])->name('report');
        Route::get('/report/export',     [Admin\LocationController::class, 'export'])->name('report.export');

        // Users
        Route::get('/users',                   [Admin\UserController::class, 'index'])->name('adduser');
        Route::get('/users/create',            [Admin\UserController::class, 'create'])->name('adduser.create');
        Route::post('/users',                  [Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit',       [Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',            [Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',         [Admin\UserController::class, 'destroy'])->name('users.destroy');
        
        // User Approval
        Route::post('/users/{user}/approve',   [Admin\UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject',    [Admin\UserController::class, 'reject'])->name('users.reject');
        Route::post('/users/approve-all',      [Admin\UserController::class, 'approveAll'])->name('users.approve-all');

        // Downloads
        Route::get('/download', [Admin\DownloadController::class, 'index'])->name('download');

        // Municipalities
        Route::get('/municipality',        [Admin\MunicipalityController::class, 'index'])->name('municipal');
        Route::get('/municipality/create', [Admin\MunicipalityController::class, 'create'])->name('municipal.create');
        Route::post('/municipality',       [Admin\MunicipalityController::class, 'store'])->name('municipal.store');
        Route::delete('/municipality/{id}',[Admin\MunicipalityController::class, 'destroy'])->name('municipal.destroy');

        // Notifications
        Route::get('/notifications',              [Admin\NotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/unread-count', [Admin\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
        Route::get('/notifications/recent',       [Admin\NotificationController::class, 'getRecent'])->name('notifications.recent');
        Route::post('/notifications/{id}/read',   [Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/{id}',      [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('/notifications/clear-read',  [Admin\NotificationController::class, 'clearRead'])->name('notifications.clear-read');
    });

// Redirect /users to /user for convenience
Route::redirect('/users', '/user');

// User dashboard routes
Route::middleware(['user','auth'])->group(function () {
    Route::redirect('/user', '/user/dashboard');
    Route::get('/user/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/account', [UserLocationController::class, 'account'])->name('user.account');
    // Update user profile and password
    Route::post('/user/account/update', [UserController::class, 'updateProfile'])->name('user.account.update');
    Route::post('/user/account/password', [UserController::class, 'updatePassword'])->name('user.account.password');
    Route::get('/user/index', [UserLocationController::class, 'index'])->name('user.locations.index');
    Route::get('user/locations/create', [UserLocationController::class, 'create'])->name('locations.create');
    Route::get('/user/sightings-map', [UserLocationController::class, 'index'])->name('user.sightings-map');
    Route::post('/user/sightings-map', [UserLocationController::class, 'store'])->name('user-save-location');
    Route::delete('/user/sightings-map/{id}', [UserLocationController::class, 'destroy'])->name('user.sightings-map.destroy');
    Route::get('/user/download', [UserDownloadController::class, 'index'])->name('user.download');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\UserDownloadController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserLocationController;
use App\Http\Controllers\MunicipalityController;
use App\Exports\LocationsReportExport;
use Maatwebsite\Excel\Facades\Excel;

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
Route::middleware('admin')->group(function () {
    // Dashboard and Location Routes
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');
    Route::post('/save-location', [LocationController::class, 'store'])->name('save-location');
    Route::get('/admin/locations', [LocationController::class, 'index'])->name('admin.location');
    Route::delete('/locations/{id}', [LocationController::class, 'destroy'])->name('locations.destroy');
    Route::get('/admin/report', [LocationController::class, 'report'])->name('admin.report');
    Route::get('admin/report/export', [LocationController::class, 'export'])->name('admin.report.export');
    // In routes/web.php
    Route::get('/dashboard-data', [LocationController::class, 'getDashboardData'])->name('dashboard.data');



    // User Management Routes
    Route::get('/admin/adduser/create', [UserController::class, 'create'])->name('admin.adduser.create'); // Route for creating user
    Route::post('/admin/adduser/users', [UserController::class, 'store'])->name('admin.users.store'); // Route for storing user
    Route::get('/admin/adduser/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit'); // Route for editing user
    Route::put('/admin/adduser/users/{user}', [UserController::class, 'update'])->name('admin.users.update'); // Route for updating user
    Route::delete('/admin/adduser/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy'); // Route for deleting user
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.adduser'); // Route for listing users



    Route::get('/admin/municipal/create', [MunicipalityController::class, 'create'])->name('admin.municipal.create');
    Route::post('/admin/municipal', [MunicipalityController::class, 'store'])->name('admin.municipal.store');
    Route::get('/admin/municipality', [MunicipalityController::class, 'index'])->name('admin.municipal');
    Route::delete('/admin/municipality/{id}', [MunicipalityController::class, 'destroy'])->name('admin.municipal.destroy');
});

// User dashboard routes
Route::middleware(['user','auth'])->group(function () {
    Route::get('/user', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/index', [UserDashboardController::class, 'index'])->name('user.index');
    Route::get('user/locations/create', [UserLocationController::class, 'create'])->name('locations.create');
    Route::get('/user/locations', [UserLocationController::class, 'index'])->name('user.locations');
    Route::post('/user/locations', [UserLocationController::class, 'store'])->name('user-save-location');
    Route::get('user/index', [UserLocationController::class, 'index'])->name('user.index');
        Route::get('/user/download', [UserDownloadController::class, 'index'])->name('user.download');
});
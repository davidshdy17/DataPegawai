<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');
});
Route::middleware('auth')->group(function () {
        // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Route AJAX search harus sebelum resource
    Route::get('/employees/search', [EmployeeController::class, 'search'])
        ->name('employees.search');

    Route::resource('employees', EmployeeController::class);
        Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
});
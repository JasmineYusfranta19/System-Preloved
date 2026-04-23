<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\AdminController\AuthController;
use App\Http\Controllers\AdminController\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TesterController::class, 'index']);

Route::prefix('admin')->group(function () {

    Route::middleware('guest')->controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register');
    });

    Route::middleware('auth')->group (function () {

        Route::controller(DashboardController::class)->group(function (){
            Route::get('/dashboard', 'index')->name('dashboard');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
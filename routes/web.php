<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
  Route::view('/', 'index')->name('login');
  Route::post('/login', [UserController::class, 'login']);
});

Route::middleware('auth')->group(function() {
  Route::get('/logout', [UserController::class, 'logout']);
  
  Route::prefix('dashboard')->group(function() {
    Route::get('/', [AccountController::class, 'index']);
    Route::post('add', [AccountController::class, 'add']);
    Route::put('/update/{id}', [AccountController::class, 'update']);
    Route::delete('/delete/{id}', [AccountController::class, 'delete']);
  });
});
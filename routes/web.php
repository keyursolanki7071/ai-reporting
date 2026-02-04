<?php

use App\Http\Controllers\DatabaseConfigController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index'])->name('home');
Route::post('/database-configs/test-connection', [DatabaseConfigController::class, 'testConnection'])->name('database-configs.test-connection');
Route::resource('database-configs', DatabaseConfigController::class);
Route::post('/chat', [ReportController::class, 'chat'])->name('chat.store');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('backups', BackupController::class)->only(['index', 'store', 'destroy']);
Route::delete('backups', [BackupController::class, 'clean'])->name('backups.clean');
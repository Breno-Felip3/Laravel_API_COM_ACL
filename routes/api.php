<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ACLMiddleware;
use Illuminate\Support\Facades\Route;
 
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->name('me')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', ACLMiddleware::class])->group(function(){
    Route::apiResource('/permissions', PermissionController::class);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/permissions-sync', [PermissionUserController::class, 'syncPermissionsOfUser'])->name('users.permissions.sync');
    Route::get('/users/{user}/permissions', [PermissionUserController::class, 'getPermissionsOfUser'])->name('users.permissions');
});


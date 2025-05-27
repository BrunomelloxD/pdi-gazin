<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/api/v1')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}', [UserController::class, 'find'])->name('user.find');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
});

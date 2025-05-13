<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
// Route::get('/users/{id}/edit', [UsersManagementController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');

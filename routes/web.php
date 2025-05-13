<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\ReviewsManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');

Route::get('/reviews', [ReviewsManagementController::class, 'index'])->name('reviews.index');
Route::put('/reviews/{id}', [ReviewsManagementController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{id}', [ReviewsManagementController::class, 'destroy'])->name('reviews.destroy');

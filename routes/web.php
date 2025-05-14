<?php

use App\Http\Controllers\FilmManagementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CastController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\ReviewsManagementController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');

Route::get('/films', [FilmManagementController::class, 'index'])->name('films.index');

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/casts', [CastController::class, 'index']);

Route::get('/reviews', [ReviewsManagementController::class, 'index'])->name('reviews.index');
Route::put('/reviews/{id}', [ReviewsManagementController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{id}', [ReviewsManagementController::class, 'destroy'])->name('reviews.destroy');

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
Route::get('/films/add', [FilmManagementController::class, 'add'])->name('films.add');
Route::get('/films/{id}/edit', [FilmManagementController::class, 'edit'])->name('films.edit');
Route::put('/films/{id}', [FilmManagementController::class, 'update'])->name('films.update');
Route::get('/films/{id}', [FilmManagementController::class, 'destroy'])->name('films.destroy');

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::put('/genres/store', [GenreController::class, 'store'])->name('genres.store');
Route::delete('/genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');

Route::get('/casts', [CastController::class, 'index'])->name('casts.index');
Route::put('/casts/store', [CastController::class, 'store'])->name('casts.store');
Route::delete('/casts/{id}', [CastController::class, 'destroy'])->name('casts.destroy');

Route::get('/reviews', [ReviewsManagementController::class, 'index'])->name('reviews.index');
Route::put('/reviews/{id}', [ReviewsManagementController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{id}', [ReviewsManagementController::class, 'destroy'])->name('reviews.destroy');

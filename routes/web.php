<?php

use App\Http\Controllers\FilmManagementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CastController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\ReviewsManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;


Route::middleware(AdminAuth::class)->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login_form');
    Route::post('/login_process', [AuthController::class, 'loginProcess'])->name('login_process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');

    Route::get('/films', [FilmManagementController::class, 'index'])->name('films.index');
    Route::get('/films/add', [FilmManagementController::class, 'add'])->name('films.add');
    Route::post('/films/store', [FilmManagementController::class, 'store'])->name('films.store');
    Route::get('/films/{id}/edit', [FilmManagementController::class, 'edit'])->name('films.edit');
    Route::put('/films/{id}', [FilmManagementController::class, 'update'])->name('films.update');
    Route::delete('/films/{id}', [FilmManagementController::class, 'destroy'])->name('films.destroy');

    Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
    Route::post('/genres/store', [GenreController::class, 'store'])->name('genres.store');
    Route::put('/genres/{id}', [GenreController::class, 'update'])->name('genres.update');
    Route::delete('/genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');

    Route::get('/casts', [CastController::class, 'index'])->name('casts.index');
    Route::post('/casts/store', [CastController::class, 'store'])->name('casts.store');
    Route::put('/casts/{id}', [CastController::class, 'update'])->name('casts.update');
    Route::delete('/casts/{id}', [CastController::class, 'destroy'])->name('casts.destroy');

    Route::get('/reviews', [ReviewsManagementController::class, 'index'])->name('reviews.index');
    Route::put('/reviews/{id}', [ReviewsManagementController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewsManagementController::class, 'destroy'])->name('reviews.destroy');
});

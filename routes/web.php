<?php

use App\Http\Controllers\FilmManagementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');

Route::get('/films', [FilmManagementController::class, 'index'])->name('films.index');

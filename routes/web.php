<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CastController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UsersManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');

Route::get('/genre', function () {
    return view('genre');
});

Route::get('/cast', function () {
    return view('cast');
});

Route::get('/admin/genres', [GenreController::class, 'index']);
Route::get('admin/cast', [CastController::class, 'index']);

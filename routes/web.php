<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CastController;
use App\Http\Controllers\GenreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/genre', function () {
    return view('genre');
});

Route::get('/cast', function () {
    return view('cast');
});

Route::get('/admin/genres', [GenreController::class, 'index']);
Route::get('admin/cast', [CastController::class, 'index']);

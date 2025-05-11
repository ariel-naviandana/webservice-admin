<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;

class GenreController extends Controller
{
    public function index()
    {
        return view('genre');
//        $response = Http::get('https://api.example.com/api/genres');
//
//        if ($response->successful()) {
//            $genres = $response->json();
//            return view('admin.genre.index', compact('genres'));
//        } else {
//            return back()->with('error', 'Gagal mengambil data genre.');
//        }
    }

    public function create(){

    }

    public function update(){

    }

    public function delete(){

    }
}

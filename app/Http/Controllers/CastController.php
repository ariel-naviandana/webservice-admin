<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;

class CastController extends Controller
{
    public function index()
    {
        return view('cast');
//        $response = Http::get('https://api.example.com/api/casts');
//
//        if ($response->successful()) {
//            $casts = $response->json(); // asumsikan API kembalikan array JSON
//            return view('admin.cast.index', compact('casts'));
//        } else {
//            return back()->with('error', 'Gagal mengambil data cast.');
//        }
    }

    public function create(){

    }

    public function update(){

    }

    public function delete(){

    }
}

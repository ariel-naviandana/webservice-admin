<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';
    public function index(Request $request)
    {
        $response = Http::get("{$this->apiBaseUrl}/genres");

        if ($response->successful()) {
            $genres = $response->json();
            $editingGenre = null;

            if ($request->has('edit_id')) {
                $genreRes = Http::get("{$this->apiBaseUrl}/genres/{$request->edit_id}");
                if ($genreRes->successful()) {
                    $editingGenre = $genreRes->json();
                }
            }

            return view('genre', compact('genres', 'editingGenre'));
        }

        return view('genre')->with('message', 'Gagal memuat data user.');
    }

    public function create(){

    }

    public function update(){

    }

    public function destroy($id){
        $response = Http::delete("{$this->apiBaseUrl}/genres/{$id}");

        if ($response->successful()) {
            return redirect()->route('genres.index')->with('message', 'Genre yang dipilih berhasil dihapus.');
        }

        return redirect()->route('genres.index')->with('message', 'Gagal menghapus genre yang dipilih.');
    }
}

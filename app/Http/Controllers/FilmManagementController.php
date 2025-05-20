<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilmManagementController extends Controller
{

    private $apiBaseUrl = 'http://localhost:8000/api';
    public function index()
    {
        $response = Http::get("{$this->apiBaseUrl}/films");
        if ($response->successful()) {
            $films = $response->json();
            return view('films', compact('films'));
        } else {
            return view('films');
        }
    }
    public function store()
    {
        $response = Http::post("{$this->apiBaseUrl}/films");
        // $responseCast = Http::get("{$this->apiBaseUrl}/");
        // $responseGenres = Http::get("{$this->apiBaseUrl}/{$id}");
    }
    public function update(Request $request, $id)
    {
        // Validasi Input
        $response = Http::put("{$this->apiBaseUrl}/films/{$id}", $request);

        if ($response->successful()) {
            return redirect()->route('films.index')->with('success', 'Film berhasil diperbarui.');
        } else {
            return back()->with('error', 'Gagal merubah film');
        }
    }
    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/films/{$id}");
        if ($response->successful()) {
            return redirect()->route('films.index')->with('message', 'Film berhasil dihapus.');
        } else {
            return back()->with('error', 'Gagal menghapus film dengan ID tersebut');
        }
    }
    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/films/{$id}");
        $responseCasts = Http::get("{$this->apiBaseUrl}/casts");
        $responseGenres = Http::get("{$this->apiBaseUrl}/genres");

        if ($response->successful()) {
            $film = $response->json();
            $casts = collect($responseCasts->json())->sortBy('name')->values();
            $genres = collect($responseGenres->json())->sortBy('name')->values();
            return view('edit_films', compact('film', 'casts', 'genres', 'filmCasts', 'filmGenres', 'filmCastIds', 'filmGenreIds'));
        } else {
            return redirect()->route('films.index')->with('error', 'Gagal mengambil data film.');
        }
    }
    public function add()
    {
        $responseCasts = Http::get("{$this->apiBaseUrl}/casts");
        $responseGenres = Http::get("{$this->apiBaseUrl}/genres");
        return view('add_films');
    }
}

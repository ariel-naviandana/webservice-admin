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
        // $responseCast = Http::get("{$this->apiBaseUrl}/{$id}");
        // $responseGenres = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->successful()) {
            $film = $response->json();
            return view('edit_films', compact('film'));
        } else {
            return redirect()->route('films.index')->with('error', 'Gagal mengambil data film.');
        }
    }
    public function add()
    {
        // $response = Http::get("{$this->apiBaseUrl}/films");
        // $responseCast = Http::get("{$this->apiBaseUrl}/");
        // $responseGenres = Http::get("{$this->apiBaseUrl}/{$id}");
        return view('add_films');
    }
}

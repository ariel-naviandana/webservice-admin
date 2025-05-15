<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilmManagementController extends Controller
{

    private $apiBaseUrl = 'http://localhost:8000/api/films';
    public function index()
    {
        $response = Http::get("{$this->apiBaseUrl}");
        if ($response->successful()) {
            $films = $response->json();
            return view('films', compact('films'));
        } else {
            return view('users');
        }
    }
    public function update(Request $request, $id)
    {
        // Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'poster_url' => 'nullable|url',
            'director' => 'nullable|string|max:255'
        ]);

        $response = Http::put("{$this->apiBaseUrl}/{$id}", $validated);

        if ($response->successful()) {
            return redirect()->route('films.index')->with('success', 'Film berhasil diperbarui');
        } else {
            return back()->with('error', 'Gagal merubah film');
        }
    }
    public function destroy()
    {
        //
    }
    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->successful()) {
            $film = $response->json();
            return view('edit_films', compact('film'));
        } else {
            return redirect()->route('films.index')->with('error', 'Gagal mengambil data film.');
        }
    }
}

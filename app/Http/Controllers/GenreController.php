<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GenreController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/genres");

        if ($response->successful()) {
            $genres = $response->json();
            $editingGenre = null;

            if ($request->has('edit_id')) {
                $genreRes = Http::withToken($token)->get("{$this->apiBaseUrl}/genres/{$request->edit_id}");
                if ($genreRes->successful()) {
                    $editingGenre = $genreRes->json();
                }
            }

            return view('genre', compact('genres', 'editingGenre'));
        }

        return view('genre')->with('message', 'Gagal memuat data.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $data = $request->only('name');
        $token = Session::get('api_token');
        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/genres", $data);

        if ($response->successful()) {
            return redirect()->route('genres.index')->with('success', 'Berhasil menambahkan genre baru.');
        }

        return back()->with('error', 'Gagal menambahkan genre: ' . ($response->json('message') ?? 'Unknown error'))->withInput();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only('name');
        $token = Session::get('api_token');
        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/genres/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('genres.index')->with('success', 'Berhasil memperbarui data genre.');
        }

        return back()->with('error', 'Gagal memperbarui data genre: ' . ($response->json('message') ?? 'Unknown error'))->withInput();
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/genres/{$id}");

        if ($response->successful()) {
            return redirect()->route('genres.index')->with('message', 'Genre yang dipilih berhasil dihapus.');
        }

        return redirect()->route('genres.index')->with('message', 'Gagal menghapus genre: ' . ($response->json('message') ?? 'Unknown error'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CastController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/casts");

        if ($response->successful()) {
            $casts = $response->json();
            return view('cast', compact('casts'));
        }

        return view('cast')->with('message', 'Gagal memuat data.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'img' => 'nullable|image|max:2048',
        ]);

        // Simulasikan upload image (jika ada)
        $photoUrl = null;
        if ($request->hasFile('img')) {
            // Simulasi upload ke penyimpanan lokal/public
            $photoUrl = $request->file('img')->store('images/casts', 'public');
        }

        $data = [
            'name' => $request->input('name'),
            'birth_date' => $request->input('date_of_birth'),
            'photo_url' => $photoUrl ? asset("storage/{$photoUrl}") : null,
        ];

        $response = Http::post("{$this->apiBaseUrl}/casts", $data);

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('success', 'Berhasil menambahkan cast.');
        } else {
            return back()->with('error', 'Gagal menambahkan cast.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
        ]);

        $data = [
            'name' => $request->input('name'),
            'birth_date' => $request->input('birthdate'),
        ];

        $response = Http::put("{$this->apiBaseUrl}/casts/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('success', 'Berhasil memperbarui data cast.');
        } else {
            return back()->with('error', 'Gagal memperbarui data cast.')->withInput();
        }
    }

    public function destroy($id){
        $response = Http::delete("{$this->apiBaseUrl}/casts/{$id}");

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('message', 'Berhasil dihapus.');
        }

        return redirect()->route('casts.index')->with('message', 'Gagal menghapus data: ' . ($response->json('message') ?? 'Unknown error'));
    }
}

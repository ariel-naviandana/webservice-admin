<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CastController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $response = Http::get("{$this->apiBaseUrl}/casts");

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
            'birth_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'birth_date' => $request->birth_date,
        ];

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            try {
                $cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dto6d9tbe/image/upload';
                $cloudinaryPreset = 'projek-tis';

                $response = Http::withOptions([
                    'verify' => false,
                ])->attach(
                    'file',
                    file_get_contents($request->file('photo')->getRealPath()),
                    $request->file('photo')->getClientOriginalName()
                )->post($cloudinaryUrl, [
                    'upload_preset' => $cloudinaryPreset,
                    'folder' => 'cast_photos',
                ]);

                if ($response->successful()) {
                    $data['photo_url'] = $response->json()['secure_url'];
                } else {
                    return redirect()->route('casts.index')->with('message', 'Gagal mengunggah gambar ke Cloudinary.');
                }
            } catch (\Exception $e) {
                return redirect()->route('casts.index')->with('message', 'Gagal mengunggah gambar ke Cloudinary: ' . $e->getMessage());
            }
        }

        $response = Http::post("{$this->apiBaseUrl}/casts", $data);

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('message', 'Berhasil ditambahkan.');
        } else {
            return redirect()->route('casts.index')->with('message', 'Gagal menambahkan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'birth_date' => $request->birth_date,
        ];

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            try {
                $cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dto6d9tbe/image/upload';
                $cloudinaryPreset = 'projek-tis';

                $response = Http::withOptions([
                    'verify' => false,
                ])->attach(
                    'file',
                    file_get_contents($request->file('photo')->getRealPath()),
                    $request->file('photo')->getClientOriginalName()
                )->post($cloudinaryUrl, [
                    'upload_preset' => $cloudinaryPreset,
                    'folder' => 'cast_photos',
                ]);

                if ($response->successful()) {
                    $data['photo_url'] = $response->json()['secure_url'];
                } else {
                    return redirect()->route('casts.index')->with('message', 'Gagal mengunggah gambar ke Cloudinary.');
                }
            } catch (\Exception $e) {
                return redirect()->route('casts.index')->with('message', 'Gagal mengunggah gambar ke Cloudinary: ' . $e->getMessage());
            }
        }

        $response = Http::put("{$this->apiBaseUrl}/casts/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('message', 'Berhasil diupdate.');
        } else {
            return redirect()->route('casts.index')->with('message', 'Gagal mengupdate data.');
        }
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/casts/{$id}");

        if ($response->successful()) {
            return redirect()->route('casts.index')->with('message', 'Berhasil dihapus.');
        }

        return redirect()->route('casts.index')->with('message', 'Gagal menghapus data yang dipilih.');
    }
}

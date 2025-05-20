<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            return view('films')->with('error', 'Gagal memuat data.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'release_year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'director' => 'nullable|string|max:255',
            'rating_avg' => 'nullable|numeric|min:0|max:10',
            'cast_ids' => 'array',
            'genre_ids' => 'array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'synopsis' => $request->synopsis,
            'release_year' => $request->release_year,
            'duration' => $request->duration,
            'director' => $request->director,
            'rating_avg' => $request->rating_avg ?? 0,
            'cast_ids' => $request->cast_ids ?? [],
            'genre_ids' => $request->genre_ids ?? [],
        ];

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            try {
                $cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dto6d9tbe/image/upload';
                $cloudinaryPreset = 'projek-tis';
                $maxRetries = 3;
                $retryDelay = 1000; // 1 second

                $response = null;
                for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                    try {
                        $response = Http::withOptions([
                            'verify' => false,
                            'timeout' => 30, // Increased from default 10s to 30s
                            'connect_timeout' => 10, // Connection timeout
                        ])->attach(
                            'file',
                            file_get_contents($request->file('photo')->getRealPath()),
                            $request->file('photo')->getClientOriginalName()
                        )->post($cloudinaryUrl, [
                            'upload_preset' => $cloudinaryPreset,
                            'folder' => 'film_posters',
                        ]);

                        if ($response->successful()) {
                            $data['poster_url'] = $response->json()['secure_url'];
                            break;
                        } else {
                            Log::warning("Cloudinary upload failed on attempt {$attempt}", [
                                'status' => $response->status(),
                                'body' => $response->body(),
                            ]);
                            if ($attempt === $maxRetries) {
                                return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary setelah beberapa percobaan.');
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Cloudinary upload error on attempt {$attempt}", [
                            'message' => $e->getMessage(),
                            'file' => $request->file('photo')->getClientOriginalName(),
                        ]);
                        if ($attempt === $maxRetries) {
                            return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary: ' . $e->getMessage());
                        }
                        sleep($retryDelay / 1000);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Unexpected Cloudinary upload error', [
                    'message' => $e->getMessage(),
                    'file' => $request->file('photo')->getClientOriginalName(),
                ]);
                return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary: ' . $e->getMessage());
            }
        }

        $response = Http::post("{$this->apiBaseUrl}/films", $data);

        if ($response->successful()) {
            return redirect()->route('films.index')->with('success', 'Film berhasil ditambahkan.');
        } else {
            return back()->with('error', 'Gagal menambahkan film.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'release_year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'director' => 'nullable|string|max:255',
            'rating_avg' => 'nullable|numeric|min:0|max:10',
            'cast_ids' => 'array',
            'genre_ids' => 'array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'synopsis' => $request->synopsis,
            'release_year' => $request->release_year,
            'duration' => $request->duration,
            'director' => $request->director,
            'rating_avg' => $request->rating_avg ?? 0,
            'cast_ids' => $request->cast_ids ?? [],
            'genre_ids' => $request->genre_ids ?? [],
        ];

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            try {
                $cloudinaryUrl = 'https://api.cloudinary.com/v1_1/dto6d9tbe/image/upload';
                $cloudinaryPreset = 'projek-tis';
                $maxRetries = 3;
                $retryDelay = 1000; // 1 second

                $response = null;
                for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                    try {
                        $response = Http::withOptions([
                            'verify' => false,
                            'timeout' => 30, // Increased from default 10s to 30s
                            'connect_timeout' => 10, // Connection timeout
                        ])->attach(
                            'file',
                            file_get_contents($request->file('photo')->getRealPath()),
                            $request->file('photo')->getClientOriginalName()
                        )->post($cloudinaryUrl, [
                            'upload_preset' => $cloudinaryPreset,
                            'folder' => 'film_posters',
                        ]);

                        if ($response->successful()) {
                            $data['poster_url'] = $response->json()['secure_url'];
                            break;
                        } else {
                            Log::warning("Cloudinary upload failed on attempt {$attempt}", [
                                'status' => $response->status(),
                                'body' => $response->body(),
                            ]);
                            if ($attempt === $maxRetries) {
                                return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary setelah beberapa percobaan.');
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Cloudinary upload error on attempt {$attempt}", [
                            'message' => $e->getMessage(),
                            'file' => $request->file('photo')->getClientOriginalName(),
                        ]);
                        if ($attempt === $maxRetries) {
                            return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary: ' . $e->getMessage());
                        }
                        sleep($retryDelay / 1000);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Unexpected Cloudinary upload error', [
                    'message' => $e->getMessage(),
                    'file' => $request->file('photo')->getClientOriginalName(),
                ]);
                return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary: ' . $e->getMessage());
            }
        }

        $response = Http::put("{$this->apiBaseUrl}/films/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('films.index')->with('success', 'Film berhasil diperbarui.');
        } else {
            return back()->with('error', 'Gagal merubah film.');
        }
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/films/{$id}");
        if ($response->successful()) {
            return redirect()->route('films.index')->with('success', 'Film berhasil dihapus.');
        } else {
            return back()->with('error', 'Gagal menghapus film dengan ID tersebut.');
        }
    }

    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/films/{$id}");
        $responseCasts = Http::get("{$this->apiBaseUrl}/casts");
        $responseGenres = Http::get("{$this->apiBaseUrl}/genres");

        if ($response->successful()) {
            $film = $response->json();
            $filmCasts = collect($film['characters'])->sortBy('name')->values();
            $filmGenres = collect($film['genres'])->sortBy('name')->values();
            $filmCastIds = $filmCasts->pluck('id')->toArray();
            $filmGenreIds = $filmGenres->pluck('id')->toArray();
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
        if ($responseCasts->successful() && $responseGenres->successful()) {
            $casts = collect($responseCasts->json())->sortBy('name')->values();
            $genres = collect($responseGenres->json())->sortBy('name')->values();
            return view('add_films', compact('casts', 'genres'));
        } else {
            return redirect()->route('films.index')->with('error', 'Gagal mengambil data.');
        }
    }
}

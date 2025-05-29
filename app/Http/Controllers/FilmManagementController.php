<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FilmManagementController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index()
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->get("{$this->apiBaseUrl}/films");

            if ($response->successful()) {
                $films = $response->json();
                return view('films', compact('films'));
            }

            $msg = $response->json('message') ?? 'Gagal memuat data.';
            return view('films')->with('error', $msg);
        } catch (ConnectionException $e) {
            return view('films')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return view('films')->with('error', 'Terjadi kesalahan internal.');
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
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
                $retryDelay = 1000;

                $response = null;
                for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                    try {
                        $response = Http::withOptions([
                            'verify' => false,
                            'timeout' => 30,
                            'connect_timeout' => 10,
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
                        }
                        Log::warning("Cloudinary upload failed on attempt {$attempt}", [
                            'status' => $response ? $response->status() : 'N/A',
                            'body' => $response ? $response->body() : 'N/A',
                        ]);
                        if ($attempt === $maxRetries) {
                            return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary setelah beberapa percobaan.');
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

        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->post("{$this->apiBaseUrl}/films", $data);

            if ($response->status() === 201)
                return redirect()->route('films.index')->with('success', 'Film berhasil ditambahkan.');

            $msg = $response->json('message') ?? 'Gagal menambahkan film.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return back()->with('error', $msg);

        } catch (ConnectionException $e) {
            return back()->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan internal.');
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
                $retryDelay = 1000;

                $response = null;
                for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                    try {
                        $response = Http::withOptions([
                            'verify' => false,
                            'timeout' => 30,
                            'connect_timeout' => 10,
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
                        }
                        Log::warning("Cloudinary upload failed on attempt {$attempt}", [
                            'status' => $response ? $response->status() : 'N/A',
                            'body' => $response ? $response->body() : 'N/A',
                        ]);
                        if ($attempt === $maxRetries) {
                            return back()->with('error', 'Gagal mengunggah gambar ke Cloudinary setelah beberapa percobaan.');
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

        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->put("{$this->apiBaseUrl}/films/{$id}", $data);

            if ($response->successful()) {
                return redirect()->route('films.index')->with('success', 'Film berhasil diperbarui.');
            }

            $msg = $response->json('message') ?? 'Gagal merubah film.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return back()->with('error', $msg);

        } catch (ConnectionException $e) {
            return back()->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/films/{$id}");

            if ($response->successful()) {
                return redirect()->route('films.index')->with('success', 'Film berhasil dihapus.');
            }

            $msg = $response->json('message') ?? 'Gagal menghapus film.';
            return back()->with('error', $msg);
        } catch (ConnectionException $e) {
            return back()->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function edit($id)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->get("{$this->apiBaseUrl}/films/{$id}");
            $responseCasts = Http::withToken($token)->get("{$this->apiBaseUrl}/casts");
            $responseGenres = Http::withToken($token)->get("{$this->apiBaseUrl}/genres");

            if ($response->successful()) {
                $film = $response->json();
                $filmCasts = collect($film['characters'])->sortBy('name')->values();
                $filmGenres = collect($film['genres'])->sortBy('name')->values();
                $filmCastIds = $filmCasts->pluck('id')->toArray();
                $filmGenreIds = $filmGenres->pluck('id')->toArray();
                $casts = collect($responseCasts->json())->sortBy('name')->values();
                $genres = collect($responseGenres->json())->sortBy('name')->values();
                return view('edit_films', compact('film', 'casts', 'genres', 'filmCasts', 'filmGenres', 'filmCastIds', 'filmGenreIds'));
            }

            $msg = $response->json('message') ?? 'Gagal mengambil data film.';
            return redirect()->route('films.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('films.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('films.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function add()
    {
        $token = Session::get('api_token');
        try {
            $responseCasts = Http::withToken($token)->get("{$this->apiBaseUrl}/casts");
            $responseGenres = Http::withToken($token)->get("{$this->apiBaseUrl}/genres");

            if ($responseCasts->successful() && $responseGenres->successful()) {
                $casts = collect($responseCasts->json())->sortBy('name')->values();
                $genres = collect($responseGenres->json())->sortBy('name')->values();
                return view('add_films', compact('casts', 'genres'));
            }

            $msg = 'Gagal mengambil data.';
            return redirect()->route('films.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('films.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('films.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CastController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index(Request $request)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->get("{$this->apiBaseUrl}/casts");

            if ($response->successful()) {
                $casts = $response->json();
                return view('cast', compact('casts'));
            }

            $msg = $response->json('message') ?? 'Gagal memuat data.';
            return view('cast')->with('error', $msg);
        } catch (ConnectionException $e) {
            return view('cast')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return view('cast')->with('error', 'Terjadi kesalahan internal.');
        }
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
                $maxRetries = 3;
                $retryDelay = 1000;

                $cloudinaryResponse = null;
                for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                    try {
                        $cloudinaryResponse = Http::withOptions([
                            'verify' => false,
                            'timeout' => 30,
                            'connect_timeout' => 10,
                        ])->attach(
                            'file',
                            file_get_contents($request->file('photo')->getRealPath()),
                            $request->file('photo')->getClientOriginalName()
                        )->post($cloudinaryUrl, [
                            'upload_preset' => $cloudinaryPreset,
                            'folder' => 'cast_photos',
                        ]);

                        if ($cloudinaryResponse->successful()) {
                            $data['photo_url'] = $cloudinaryResponse->json()['secure_url'];
                            break;
                        }
                    } catch (\Throwable $e) {
                        if ($attempt === $maxRetries) {
                            return redirect()->route('casts.index')->with('error', 'Gagal mengunggah gambar.');
                        }
                        sleep($retryDelay / 1000);
                    }
                }

                if (!$cloudinaryResponse->successful()) {
                    return redirect()->route('casts.index')->with('error', 'Gagal mengunggah gambar ke Cloudinary.');
                }
            } catch (\Throwable $e) {
                return redirect()->route('casts.index')->with('error', 'Gagal mengunggah gambar.');
            }
        }

        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->post("{$this->apiBaseUrl}/casts", $data);

            if ($response->successful()) {
                return redirect()->route('casts.index')->with('success', 'Berhasil ditambahkan.');
            }

            $msg = $response->json('message') ?? 'Gagal menambahkan data.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return redirect()->route('casts.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('casts.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('casts.index')->with('error', 'Terjadi kesalahan internal.');
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
                $maxRetries = 3;
                $retryDelay = 1000;

                $cloudinaryResponse = null;
                for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                    try {
                        $cloudinaryResponse = Http::withOptions([
                            'verify' => false,
                            'timeout' => 30,
                            'connect_timeout' => 10,
                        ])->attach(
                            'file',
                            file_get_contents($request->file('photo')->getRealPath()),
                            $request->file('photo')->getClientOriginalName()
                        )->post($cloudinaryUrl, [
                            'upload_preset' => $cloudinaryPreset,
                            'folder' => 'cast_photos',
                        ]);

                        if ($cloudinaryResponse->successful()) {
                            $data['photo_url'] = $cloudinaryResponse->json()['secure_url'];
                            break;
                        }
                    } catch (\Throwable $e) {
                        if ($attempt === $maxRetries) {
                            return redirect()->route('casts.index')->with('error', 'Gagal mengunggah gambar.');
                        }
                        sleep($retryDelay / 1000);
                    }
                }

                if (!$cloudinaryResponse->successful()) {
                    return redirect()->route('casts.index')->with('error', 'Gagal mengunggah gambar ke Cloudinary.');
                }
            } catch (\Throwable $e) {
                return redirect()->route('casts.index')->with('error', 'Gagal mengunggah gambar.');
            }
        }

        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->put("{$this->apiBaseUrl}/casts/{$id}", $data);

            if ($response->successful()) {
                return redirect()->route('casts.index')->with('success', 'Berhasil diupdate.');
            }

            $msg = $response->json('message') ?? 'Gagal mengupdate data.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return redirect()->route('casts.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('casts.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('casts.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/casts/{$id}");

            if ($response->successful()) {
                return redirect()->route('casts.index')->with('success', 'Berhasil dihapus.');
            }

            $msg = $response->json('message') ?? 'Gagal menghapus data.';
            return redirect()->route('casts.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('casts.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('casts.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }
}

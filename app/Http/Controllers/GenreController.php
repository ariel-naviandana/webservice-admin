<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GenreController extends Controller
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

            $msg = $response->json('message') ?? 'Gagal memuat data.';
            return view('genre')->with('error', $msg);
        } catch (ConnectionException $e) {
            return view('genre')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return view('genre')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only('name');
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->post("{$this->apiBaseUrl}/genres", $data);

            if ($response->successful()) {
                return redirect()->route('genres.index')->with('success', 'Berhasil menambahkan genre baru.');
            }

            $msg = $response->json('message') ?? 'Gagal menambahkan genre.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return back()->with('error', $msg)->withInput();
        } catch (ConnectionException $e) {
            return back()->with('error', 'Tidak dapat terhubung ke server API.')->withInput();
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan internal.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only('name');
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->put("{$this->apiBaseUrl}/genres/{$id}", $data);

            if ($response->successful()) {
                return redirect()->route('genres.index')->with('success', 'Berhasil memperbarui data genre.');
            }

            $msg = $response->json('message') ?? 'Gagal memperbarui data genre.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return back()->with('error', $msg)->withInput();
        } catch (ConnectionException $e) {
            return back()->with('error', 'Tidak dapat terhubung ke server API.')->withInput();
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan internal.')->withInput();
        }
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/genres/{$id}");

            if ($response->successful()) {
                return redirect()->route('genres.index')->with('success', 'Genre yang dipilih berhasil dihapus.');
            }

            $msg = $response->json('message') ?? 'Gagal menghapus genre.';
            return redirect()->route('genres.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('genres.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('genres.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }
}

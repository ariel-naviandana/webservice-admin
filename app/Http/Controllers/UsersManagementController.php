<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UsersManagementController extends Controller
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
            $response = Http::withToken($token)->get("{$this->apiBaseUrl}/users");

            if ($response->successful()) {
                $users = $response->json();
                $editingUser = null;

                if ($request->has('edit_id')) {
                    $userRes = Http::withToken($token)->get("{$this->apiBaseUrl}/users/{$request->edit_id}");
                    if ($userRes->successful()) {
                        $editingUser = $userRes->json();
                    }
                }

                return view('users', compact('users', 'editingUser'));
            }

            $msg = $response->json('message') ?? 'Gagal memuat data user.';
            return view('users')->with('error', $msg);
        } catch (ConnectionException $e) {
            return view('users')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return view('users')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'role']);

        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->put("{$this->apiBaseUrl}/users/{$id}", $data);

            if ($response->successful()) {
                return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
            }

            $msg = $response->json('message') ?? 'Gagal memperbarui user.';
            if ($response->json('errors')) {
                $msg .= ' '.collect($response->json('errors'))->flatten()->join(' ');
            }
            return redirect()->route('users.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('users.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        try {
            $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/users/{$id}");

            if ($response->successful()) {
                return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
            }

            $msg = $response->json('message') ?? 'Gagal menghapus user.';
            return redirect()->route('users.index')->with('error', $msg);
        } catch (ConnectionException $e) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat terhubung ke server API.');
        } catch (\Throwable $e) {
            return redirect()->route('users.index')->with('error', 'Terjadi kesalahan internal.');
        }
    }
}

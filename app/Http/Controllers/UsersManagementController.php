<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UsersManagementController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $token = Session::get('api_token');
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

        return view('users')->with('message', 'Gagal memuat data user.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'role']);

        $token = Session::get('api_token');
        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/users/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('message', 'User berhasil diperbarui.');
        }

        return redirect()->route('users.index')->with('message', 'Gagal memperbarui user: ' . ($response->json('message') ?? 'Unknown error'));
    }

    public function destroy($id)
    {
        $token = Session::get('api_token');
        $response = Http::withToken($token)->delete("{$this->apiBaseUrl}/users/{$id}");

        if ($response->successful()) {
            return redirect()->route('users.index')->with('message', 'User berhasil dihapus.');
        }

        return redirect()->route('users.index')->with('message', 'Gagal menghapus user: ' . ($response->json('message') ?? 'Unknown error'));
    }
}

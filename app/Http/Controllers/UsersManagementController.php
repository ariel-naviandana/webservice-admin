<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsersManagementController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index()
    {
        // Ambil data user dari API
        $response = Http::get("http://localhost:8000/api/users");

        if ($response->successful()) {
            $users = $response->json();
            return view('users', compact('users'));
        } else {
            return view('users')->with('message', 'Gagal memuat data user.');
        }
    }


    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $response = Http::put("{$this->apiBaseUrl}/users/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('users')->with('message', 'User berhasil diperbarui.');
        }

        return redirect()->route('users')->with('message', 'Gagal memperbarui user.');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/users/{$id}");

        if ($response->successful()) {
            return redirect()->route('users')->with('message', 'User berhasil dihapus.');
        }

        return redirect()->route('users')->with('message', 'Gagal menghapus user.');
    }

    // public function edit($id)
    // {
    //     $response = Http::get("{$this->apiBaseUrl}/users/{$id}");

    //     if ($response->successful()) {
    //         $user = $response->json();
    //         return view('users.edit', compact('user'));
    //     }

    //     return redirect()->route('users.index')->with('message', 'Gagal mengambil data user.');
    // }
}

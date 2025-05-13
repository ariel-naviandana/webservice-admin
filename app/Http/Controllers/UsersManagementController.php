<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsersManagementController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index(Request $request)
    {
        $response = Http::get("{$this->apiBaseUrl}/users");

        if ($response->successful()) {
            $users = $response->json();
            $editingUser = null;

            if ($request->has('edit_id')) {
                $userRes = Http::get("{$this->apiBaseUrl}/users/{$request->edit_id}");
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
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $response = Http::put("{$this->apiBaseUrl}/users/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('message', 'User berhasil diperbarui.');
        }

        return redirect()->route('users.index')->with('message', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/users/{$id}");

        if ($response->successful()) {
            return redirect()->route('users.index')->with('message', 'User berhasil dihapus.');
        }

        return redirect()->route('users.index')->with('message', 'Gagal menghapus user.');
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

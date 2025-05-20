<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = Http::post("http://localhost:8000/api/login", [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->status() == 200) {
                $data = $response->json();
                $user = $data['user'];
                $token = $data['token'];

                if ($user['role'] != 'admin') {
                    return redirect()->route('login_form')->with('message', 'Anda tidak memiliki akses ke halaman ini.');
                }

                Session::put('user_id', $user['id']);
                Session::put('user_name', $user['name']);
                Session::put('user_email', $user['email']);
                Session::put('user_role', $user['role']);
                Session::put('api_token', $token);

                return redirect()->route('home.index');
            } else {
                $error = $response->json('message') ?? 'Login gagal. Silakan coba lagi.';
                return redirect()->route('login_form')->with('message', $error);
            }
        } catch (\Exception $e) {
            return redirect()->route('login_form')->with('message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login_form')->with('message', 'Berhasil logout.');
    }
}

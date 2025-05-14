<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilmManagementController extends Controller
{

    private $apiBaseUrl = 'http://localhost:8000/api/films';
    public function index()
    {
        $response = Http::get("{$this->apiBaseUrl}");
        if ($response->successful()) {
            $films = $response->json();
            return view('films', compact('films'));
        } else {
            return view('users');
        }
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy()
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000/api';

    public function index()
    {
        $response = Http::get("http://localhost:8000/api/films");
        if ($response->successful()) {
            $films = $response->json();
            return view('home', compact('films'));
        } else {
            return view('home');
        }
    }
}
